<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\I18n\FrozenTime;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 * @property \App\Model\Table\BudgetTable $Budget
 * @property \App\Model\Table\CostsTable $Costs
 */
class PagesController extends AppController
{
    /**
     * @var \Cake\Datasource\RepositoryInterface|null
     */

    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function display(string ...$path): ?Response
    {
        if (!$path) {
            return $this->redirect('/');
        }
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new ForbiddenException();
        }
        $page = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }

        $lastBudget = $this->getLastBudget();

        $this->set(compact('page', 'lastBudget'));

        try {
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    /**
     * Add budget method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function addBudget()
    {
        $budget = $this->Budget->newEmptyEntity();
        if ($this->request->is('post')) {
            $budget->date = new FrozenTime();
            $budget->budget = $this->request->getData('budget');

            if ($this->isLastBudget($budget->budget)) {
                $this->Flash->error('Budget is already ' . $budget->budget . '.');

                return $this->redirect('/');
            }

            if ($this->Budget->save($budget)) {
                $this->Flash->success('The budget was set to ' . $budget->budget . '.');
            } else {
                $this->Flash->error('The budget could not be saved. Please, try again.');
            }

            return $this->redirect('/');
        }
    }

    /**
     * Generate costs 10x/day
     * Generated costs cannot be grater than 2x maxBudget/current day
     * Generated costs sum(currentMonth) cannot be grater than sum(maxBudget/day - all month)
     */
    public function generateCosts(): ?Response
    {
        $generatedCosts = 0;

        $lastBudget = $this->getLastBudget();
        $costsCount = $this->getCostsCount(date('Y-m-d'));

        $dailyCosts = $this->dailyCosts(date('Y-m-d'));
        [$budgetPerMonth, $maxBudgetLastDay] = $this->calcBudgetPerMonth(date('Y-m'));
        $totalMonthCosts = $this->calcCostsPerMonth(date('Y-m'));

        if ($lastBudget['budget'] == 0) {
            $this->Flash->error('The budget is 0 - no costs can be generated.');
        } else {
            if ($costsCount < 10) {
                $generatedCosts = $this->generateRandomCosts($budgetPerMonth, $maxBudgetLastDay, $totalMonthCosts, $dailyCosts);

                if ($generatedCosts == 0) {
                    $this->Flash->error('Budget depleted.');

                    return $this->redirect('/');
                }

                $costs = $this->Costs->newEmptyEntity();
                $costs->date = new FrozenTime();
                $costs->costs = $generatedCosts;

                if ($this->Costs->save($costs)) {
                    $this->Flash->success('Costs generated: ' . $generatedCosts . '.');
                }
            } else {
                $this->Flash->error('The budget was already changed 10 times today.');
            }
        }

        return $this->redirect('/');
    }

    public function showHistory()
    {
        $success = true;
        $data = [];
        $msg = '';

        $threeMonthsAgo = date('Y-m', strtotime('-2 month'));
        $budgets = $this->Budget->find()->where(['date >= ' => $threeMonthsAgo . '%'])->all();
        $costs = $this->Costs->find()->where(['date >= ' => $threeMonthsAgo . '%'])->all();

        $datesList = $this->getDateList($threeMonthsAgo);

        $finalData = $this->setFinalData($datesList, $budgets, $costs);

        $data = ['finalData' => $finalData];

        $this->set(compact('data', 'success', 'msg'));
        $this->viewBuilder()->setOption('serialize', true);
        $this->RequestHandler->renderAs($this, 'json');
    }

    /**
     * Check if budget is == to last
     *
     * @param $newBudget
     * @return bool
     */
    private function isLastBudget($newBudget): bool
    {
        $last = $this->getLastBudget();

        return $last['budget'] == $newBudget;
    }

    /**
     * @return array|\Cake\Datasource\EntityInterface|null
     */
    private function getLastBudget()
    {
        return $this->Budget->find(
            'all',
            [
                'order' =>
                    [
                        'id' => 'DESC',
                    ],
            ]
        )->first();
    }

    /**
     * Calculate budget per month and lastday max budget
     *
     * @param $month
     * @return float[]|int[]
     */
    private function calcBudgetPerMonth($month)
    {
        $budgetPerMonth = 0;
        $date = '';
        $itemsArray = [];
        $maxBudgetLastDay = 0;

        $items = $this->Budget->find()->where(['date LIKE ' => $month . '%'])->all();

        $countItems = count($items);

        foreach ($items as $k => $item) {
            $itemDate = $item['date']->year . $item['date']->month . $item['date']->day;
            if ($date !== $itemDate) {
                $date = $itemDate;
                $maxBudgetLastDay = $this->checkMaxBudgetPerDay($itemsArray);
                $budgetPerMonth += $maxBudgetLastDay;
                $itemsArray = [];
            }

            array_push($itemsArray, $item);

            if ($k == $countItems - 1) {
                $maxBudgetLastDay = $this->checkMaxBudgetPerDay($itemsArray);
                $budgetPerMonth += $maxBudgetLastDay;
                break;
            }
        }

        return [$budgetPerMonth, $maxBudgetLastDay];
    }

    /**
     * Get max Budget per day and count budget change per day (current day)
     *
     * @param $items
     * @return float
     */
    private function checkMaxBudgetPerDay($items): float
    {
        $maxBudget = 0;

        if (!empty($items)) {
            foreach ($items as $item) {
                if ($item['budget'] > $maxBudget) {
                    $maxBudget = $item['budget'];
                }
            }
        }

        return $maxBudget;
    }

    /**
     * Count costs
     *
     * @param $day
     * @return int
     */
    private function getCostsCount($day): int
    {
        return $this->Costs->find()->where(['date LIKE ' => $day . '%'])->count();
    }

    /**
     * Calc costs per month
     *
     * @param $month
     * @return int|mixed
     */
    private function calcCostsPerMonth($month)
    {
        $costsMonthly = 0;

        $items = $this->Costs->find()->where(['date LIKE ' => $month . '%'])->all();

        foreach ($items as $item) {
            $costsMonthly += $item['costs'];
        }

        return $costsMonthly;
    }

    /**
     * Calc costs daily
     *
     * @param $day
     * @return int|mixed
     */
    private function dailyCosts($day)
    {
        $dailyCosts = 0;
        $costs = $this->Costs->find()->where(['date LIKE ' => $day . '%'])->all();

        foreach ($costs as $cost) {
            $dailyCosts += $cost['costs'];
        }

        return $dailyCosts;
    }

    /**
     * Generate random costs
     *
     * @param $maxBudgetMonth
     * @param $maxBudgetDay
     * @param $totalMonthCosts
     * @param $lastDayCosts
     * @return float|int
     */
    private function generateRandomCosts($maxBudgetMonth, $maxBudgetDay, $totalMonthCosts, $lastDayCosts)
    {
        $doubleDayBudget = $maxBudgetDay * 2;
        $monthlyBudgetLeft = $maxBudgetMonth - $totalMonthCosts;
        $dailyBudgetLeft = $doubleDayBudget - $lastDayCosts;
        $maxRand = $monthlyBudgetLeft > $dailyBudgetLeft ? $dailyBudgetLeft : $monthlyBudgetLeft;

        $maxRand *= 100;

        return mt_rand(0, (int)$maxRand) / 100;
    }

    /**
     * @param $threeMonthsAgo
     * @return array
     */
    private function getDateList($threeMonthsAgo)
    {
        $dates = [];

        $startDate = $threeMonthsAgo . '-01';
        $endDate = date('Y-m-d');

        while (strtotime($startDate) <= strtotime($endDate)) {
            array_push($dates, $startDate);
            $startDate = date('Y-m-d', strtotime('+1 day', strtotime($startDate)));
        }

        return $dates;
    }

    /**
     * @param $dates
     * @param $bugets
     * @param $costs
     */
    private function setFinalData($dates, $budgets, $costs)
    {
        $data = [];

        foreach ($dates as $k => $date) {
            $data[$k]['date'] = $date;
            $data[$k]['maxBudget'] = $this->setMaxBudgetPerDay($budgets, $date);
            $data[$k]['dailyCosts'] = $this->setDailyCosts($costs, $date);
        }

        return $data;
    }

    /**
     * @param $budgets
     * @param $date
     * @return int
     */
    private function setMaxBudgetPerDay($budgets, $date)
    {
        $maxBudget = 0;

        foreach ($budgets as $budget) {
            if ($budget['date']->format('Y-m-d') == $date && $budget['budget'] > $maxBudget) {
                $maxBudget = $budget['budget'];
            }
        }

        return $maxBudget;
    }

    /**
     * @param $costs
     * @param $date
     * @return int
     */
    private function setDailyCosts($costs, $date)
    {
        $dailyCosts = 0;

        foreach ($costs as $cost) {
            if ($cost['date']->format('Y-m-d') === $date) {
                $dailyCosts += $cost['costs'];
            }
        }

        return $dailyCosts;
    }
}
