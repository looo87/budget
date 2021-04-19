<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Budget Controller
 *
 * @property \App\Model\Table\BudgetTable $Budget
 * @method \App\Model\Entity\Budget[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BudgetController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $budget = $this->paginate($this->Budget);

        $this->set(compact('budget'));
    }

    /**
     * View method
     *
     * @param string|null $id Budget id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $budget = $this->Budget->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('budget'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $budget = $this->Budget->newEmptyEntity();
        if ($this->request->is('post')) {
            $budget = $this->Budget->patchEntity($budget, $this->request->getData());

            if ($this->Budget->save($budget)) {
                $this->Flash->success(__('The budget has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The budget could not be saved. Please, try again.'));
        }
        $this->set(compact('budget'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Budget id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $budget = $this->Budget->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $budget = $this->Budget->patchEntity($budget, $this->request->getData());
            if ($this->Budget->save($budget)) {
                $this->Flash->success(__('The budget has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The budget could not be saved. Please, try again.'));
        }
        $this->set(compact('budget'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Budget id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $budget = $this->Budget->get($id);
        if ($this->Budget->delete($budget)) {
            $this->Flash->success(__('The budget has been deleted.'));
        } else {
            $this->Flash->error(__('The budget could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
