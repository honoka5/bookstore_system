<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * DeliveryContentManagement Controller
 */
class DeliveryContentManagementController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->DeliveryContentManagement->find();
        $deliveryContentManagement = $this->paginate($query);

        $this->set(compact('deliveryContentManagement'));

        return null;
    }

    /**
     * View method
     *
     * @param string|null $id Delivery Content Management id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null)
    {
        $deliveryContentManagement = $this->DeliveryContentManagement->get($id, contain: []);
        $this->set(compact('deliveryContentManagement'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $deliveryContentManagement = $this->DeliveryContentManagement->newEmptyEntity();
        if ($this->request->is('post')) {
            $deliveryContentManagement = $this->DeliveryContentManagement->patchEntity($deliveryContentManagement, $this->request->getData());
            if ($this->DeliveryContentManagement->save($deliveryContentManagement)) {
                $this->Flash->success(__('The delivery content management has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery content management could not be saved. Please, try again.'));
        }
        $this->set(compact('deliveryContentManagement'));

        return null;
    }

    /**
     * Edit method
     *
     * @param string|null $id Delivery Content Management id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $deliveryContentManagement = $this->DeliveryContentManagement->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $deliveryContentManagement = $this->DeliveryContentManagement->patchEntity($deliveryContentManagement, $this->request->getData());
            if ($this->DeliveryContentManagement->save($deliveryContentManagement)) {
                $this->Flash->success(__('The delivery content management has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The delivery content management could not be saved. Please, try again.'));
        }
        $this->set(compact('deliveryContentManagement'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Delivery Content Management id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $deliveryContentManagement = $this->DeliveryContentManagement->get($id);
        if ($this->DeliveryContentManagement->delete($deliveryContentManagement)) {
            $this->Flash->success(__('The delivery content management has been deleted.'));
        } else {
            $this->Flash->error(__('The delivery content management could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
