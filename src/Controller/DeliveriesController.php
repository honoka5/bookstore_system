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
     * コントローラ初期化処理。
     * Deliveriesテーブルのロードを行います。
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Deliveries = $this->fetchTable('Deliveries');
    }

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
    public function view(?string $id = null)
    {
        $delivery = $this->Deliveries->get($id, [
            'contain' => ['Customers', 'Orders', 'DeliveryContentManagement'],
        ]);
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
                $this->Flash->success(__('納品書を作成しました。'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('納品書の作成に失敗しました。もう一度お試しください。'));
        }
        // 顧客リスト・注文書リストを取得
        $customers = $this->Deliveries->Customers->find('list', ['keyField' => 'customer_id', 'valueField' => 'name'])->toArray();
        $orders = $this->Deliveries->Orders->find('list', ['keyField' => 'order_id', 'valueField' => 'order_id'])->toArray();
        $this->set(compact('delivery', 'customers', 'orders'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Delivery id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
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

        return null;
    }

    /**
     * Delete method
     *
     * @param string|null $id Delivery id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
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
