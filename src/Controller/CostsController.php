<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Costs Controller
 *
 * @property \App\Model\Table\CostsTable $Costs
 * @method \App\Model\Entity\Cost[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CostsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $costs = $this->paginate($this->Costs);

        $this->set(compact('costs'));
    }

    /**
     * View method
     *
     * @param string|null $id Cost id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cost = $this->Costs->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('cost'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cost = $this->Costs->newEmptyEntity();
        if ($this->request->is('post')) {
            $cost = $this->Costs->patchEntity($cost, $this->request->getData());
            if ($this->Costs->save($cost)) {
                $this->Flash->success(__('The cost has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cost could not be saved. Please, try again.'));
        }
        $this->set(compact('cost'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Cost id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cost = $this->Costs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cost = $this->Costs->patchEntity($cost, $this->request->getData());
            if ($this->Costs->save($cost)) {
                $this->Flash->success(__('The cost has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cost could not be saved. Please, try again.'));
        }
        $this->set(compact('cost'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cost id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cost = $this->Costs->get($id);
        if ($this->Costs->delete($cost)) {
            $this->Flash->success(__('The cost has been deleted.'));
        } else {
            $this->Flash->error(__('The cost could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
