<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Deliveries Controller
 *
 * @property \App\Model\Table\DeliveriesTable $Deliveries
 */
class DeliveriesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Deliveries->find();
            // ->contain(['Orders']);
        $deliveries = $this->paginate($query);

        $this->set(compact('deliveries'));
    }

    /**
     * View method
     *
     * @param string|null $id Delivery id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $delivery = $this->Deliveries->get($id, contain: ['Orders']);
        $this->set(compact('delivery'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $delivery = $this->Deliveries->newEmptyEntity();
        if ($this->request->is('post')) {
            $delivery = $this->Deliveries->patchEntity($delivery, $this->request->getData());
            if ($this->Deliveries->save($delivery)) {
                $this->Flash->success(__('The delivery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery could not be saved. Please, try again.'));
        }
        $orders = $this->Deliveries->Orders->find('list', limit: 200)->all();
        $this->set(compact('delivery', 'orders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Delivery id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $delivery = $this->Deliveries->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $delivery = $this->Deliveries->patchEntity($delivery, $this->request->getData());
            if ($this->Deliveries->save($delivery)) {
                $this->Flash->success(__('The delivery has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery could not be saved. Please, try again.'));
        }
        $orders = $this->Deliveries->Orders->find('list', limit: 200)->all();
        $this->set(compact('delivery', 'orders'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Delivery id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $delivery = $this->Deliveries->get($id);
        if ($this->Deliveries->delete($delivery)) {
            $this->Flash->success(__('The delivery has been deleted.'));
        } else {
            $this->Flash->error(__('The delivery could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
