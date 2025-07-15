<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Datasource\ConnectionManager;

class RegDeliveriesController extends AppController
{
    /**
     * 顧客選択画面の表示・検索処理。
     * キーワードで顧客名を部分一致検索します。
     *
     * @return void
     */
    public function selectCustomer()
    {
        $keyword = $this->request->getQuery('keyword');
        $page = (int)$this->request->getQuery('page', 1);
        $limit = 10;
        $customersTable = $this->fetchTable('Customers');
        $ordersTable = $this->fetchTable('Orders');
        $orderItemsTable = $this->fetchTable('OrderItems');
        $deliveryItemsTable = $this->fetchTable('DeliveryItems');

        // 未納品のある顧客ID一覧を取得
        $undeliveredCustomerIds = [];
        $orderItemRows = $deliveryItemsTable->find()
            ->select(['orderItem_id'])
            ->where(['is_delivered_flag' => 0])
            ->enableHydration(false)
            ->toArray();
        $orderItemIds = array_column($orderItemRows, 'orderItem_id');
        if (!empty($orderItemIds)) {
            $orderRows = $orderItemsTable->find()
                ->select(['order_id'])
                ->where(['orderItem_id IN' => $orderItemIds])
                ->enableHydration(false)
                ->toArray();
            $orderIds = array_column($orderRows, 'order_id');
            if (!empty($orderIds)) {
                $customerRows = $ordersTable->find()
                    ->select(['customer_id'])
                    ->where(['order_id IN' => $orderIds])
                    ->enableHydration(false)
                    ->toArray();
                $undeliveredCustomerIds = array_unique(array_column($customerRows, 'customer_id'));
            }
        }

        $query = $customersTable->find('all');
        if (!empty($undeliveredCustomerIds)) {
            $query->where(['customer_id IN' => $undeliveredCustomerIds]);
        } else {
            $query->where(['customer_id IS' => null]); // 空リストの場合は何も出さない
        }
        if (!empty($keyword)) {
            $query->where([
                'OR' => [
                    'name LIKE' => '%' . $keyword . '%',
                    'customer_id LIKE' => '%' . $keyword . '%',
                    'contact_Person LIKE' => '%' . $keyword . '%',
                ]
            ]);
        }
        $total = $query->count();
        $customers = $query
            ->order(['customer_id' => 'ASC'])
            ->limit($limit)
            ->offset(($page - 1) * $limit);
        $totalPages = ($limit > 0) ? (int)ceil($total / $limit) : 1;
        $this->set(compact('customers', 'keyword', 'page', 'limit', 'total', 'totalPages'));
    }

    // 納品内容選択画面
    public function selectDeliveries($customerId = null)
    {
        if (!$customerId) {
            return $this->redirect(['action' => 'selectCustomer']);
        }
        $orderTable = TableRegistry::getTableLocator()->get('Orders');
        $orderItemsTable = TableRegistry::getTableLocator()->get('OrderItems');
        $deliveryItemsTable = TableRegistry::getTableLocator()->get('DeliveryItems');

        // 顧客の注文書ID一覧を取得
        $orderIds = $orderTable->find()
            ->select(['order_id'])
            ->where(['customer_id' => $customerId])
            ->enableHydration(false)
            ->all()
            ->map(function($row){ return $row['order_id']; })
            ->toList();

        // 注文内容ID一覧を取得
        $orderItemIds = [];
        if (!empty($orderIds)) {
            $orderItemIds = $orderItemsTable->find()
                ->select(['orderItem_id'])
                ->where(['order_id IN' => $orderIds])
                ->enableHydration(false)
                ->all()
                ->map(function($row){ return $row['orderItem_id']; })
                ->toList();
        }

        // 未納納品内容を取得
        $deliveryItems = [];
        $deliveredSums = [];
        $undeliveredSums = [];
        if (!empty($orderItemIds)) {
            $deliveryItems = $deliveryItemsTable->find()
                ->where([
                    'DeliveryItems.is_delivered_flag' => 0,
                    'DeliveryItems.orderItem_id IN' => $orderItemIds
                ])
                ->contain(['OrderItems'])
                ->all();

            // 各注文内容IDごとの納品済み数量合計を取得
            $deliveredRows = $deliveryItemsTable->find()
                ->select([
                    'orderItem_id',
                    'total' => $deliveryItemsTable->find()->func()->sum('book_amount')
                ])
                ->where([
                    'DeliveryItems.is_delivered_flag' => 1,
                    'DeliveryItems.orderItem_id IN' => $orderItemIds
                ])
                ->group('orderItem_id')
                ->enableHydration(false)
                ->toArray();
            foreach ($deliveredRows as $row) {
                $deliveredSums[$row['orderItem_id']] = (int)$row['total'];
            }

            // 各注文内容IDごとの未納品数量合計を取得
            $undeliveredRows = $deliveryItemsTable->find()
                ->select([
                    'orderItem_id',
                    'total' => $deliveryItemsTable->find()->func()->sum('book_amount')
                ])
                ->where([
                    'DeliveryItems.is_delivered_flag' => 0,
                    'DeliveryItems.orderItem_id IN' => $orderItemIds
                ])
                ->group('orderItem_id')
                ->enableHydration(false)
                ->toArray();
            foreach ($undeliveredRows as $row) {
                $undeliveredSums[$row['orderItem_id']] = (int)$row['total'];
            }
        }

        $this->set(compact('deliveryItems', 'customerId', 'deliveredSums', 'undeliveredSums'));
    }

    /**
     * 指定テーブルのIDを自動採番（最大値+1、n桁ゼロ埋め）で生成する
     *
     * @param \Cake\ORM\Table $table
     * @param string $column カラム名
     * @param int $length 桁数
     * @return string
     */
    private function generateNextId($table, string $column, int $length)
    {
        $max = $table->find()
            ->select([$column])
            ->order([$column => 'DESC'])
            ->first();
        $next = $max
            ? str_pad((string)(((int)$max[$column]) + 1), $length, '0', STR_PAD_LEFT)
            : str_pad('1', $length, '0', STR_PAD_LEFT);
        return $next;
    }

    // 納品登録処理
    public function registerDeliveries()
    {
        $this->request->allowMethod(['post']);
        $data = $this->request->getData();
        $deliveryItemsTable = TableRegistry::getTableLocator()->get('DeliveryItems');
        $orderItemsTable = TableRegistry::getTableLocator()->get('OrderItems');
        $deliveriesTable = TableRegistry::getTableLocator()->get('Deliveries');
        $orderTable = TableRegistry::getTableLocator()->get('Orders');
        $connection = ConnectionManager::get('default');
        $connection->begin();
        try {
            // 新しい納品書IDを採番
            $nextDeliveryId = $this->generateNextId($deliveriesTable, 'delivery_id', 5);
            $deliveryDate = $data['delivery_date'] ?? date('Y-m-d');
            $delivery = $deliveriesTable->newEntity([
                'delivery_id' => $nextDeliveryId,
                'customer_id' => $data['customer_id'],
                'delivery_date' => $deliveryDate,
            ]);
            $deliveriesTable->save($delivery);

            $allZero = true;
            foreach ($data['quantities'] as $deliveryItemId => $quantity) {
                if ((int)$quantity > 0) {
                    $allZero = false;
                    break;
                }
            }
            if ($allZero) {
                $this->Flash->error('納品数量を入力してください');
                return $this->redirect(['action' => 'selectDeliveries', $data['customer_id']]);
            }

            // deliveredSumsを再計算
            $deliveredSums = [];
            $deliveredRows = $deliveryItemsTable->find()
                ->select([
                    'orderItem_id',
                    'total' => $deliveryItemsTable->find()->func()->sum('book_amount')
                ])
                ->where([
                    'DeliveryItems.is_delivered_flag' => 1
                ])
                ->group('orderItem_id')
                ->enableHydration(false)
                ->toArray();
            foreach ($deliveredRows as $row) {
                $deliveredSums[$row['orderItem_id']] = (int)$row['total'];
            }

            foreach ($data['quantities'] as $deliveryItemId => $quantity) {
                if ((int)$quantity > 0) {
                    $deliveryItem = $deliveryItemsTable->get($deliveryItemId);
                    $orderItem = $orderItemsTable->get($deliveryItem->orderItem_id);

                    $order = $orderTable->get($orderItem->order_id);
                    $orderQuantity = $orderItem->book_amount;
                    // deliveredSumsを利用して、未納可能な最大数量を算出
                    $deliveredSum = isset($deliveredSums[$deliveryItem->orderItem_id]) ? (int)$deliveredSums[$deliveryItem->orderItem_id] : 0;
                    $max = max(0, $orderQuantity - $deliveredSum);
                    if ((int)$quantity > $max) {
                        $quantity = $max;
                    }
                    if ((int)$quantity == $max) {
                        // 完全納品
                        $deliveryItem->is_delivered_flag = 1;
                        $deliveryItem->delivery_id = $nextDeliveryId;
                        $deliveryItem->book_amount = (int)$quantity;
                        // リードタイム計算: 納品日を指定日で計算
                        $deliveryDateObj = new \DateTime($deliveryDate);
                        $orderDateObj = new \DateTime($order->order_date);
                        $deliveryItem->leadTime = $orderDateObj->diff($deliveryDateObj)->days;
                        $deliveryItemsTable->save($deliveryItem);
                    } else {
                        // 部分納品
                        $nextDeliveryItemId = $this->generateNextId($deliveryItemsTable, 'deliveryItem_id', 6);
                        $newDeliveryItem = $deliveryItemsTable->newEntity($deliveryItem->toArray());
                        $newDeliveryItem->deliveryItem_id = $nextDeliveryItemId;
                        $newDeliveryItem->book_amount = $max - (int)$quantity;
                        $newDeliveryItem->is_delivered_flag = 0;
                        $newDeliveryItem->delivery_id = null;
                        $newDeliveryItem->orderItem_id = $deliveryItem->orderItem_id;
                        $newDeliveryItem->leadTime = null;
                        $deliveryItemsTable->save($newDeliveryItem);

                        $deliveryItem->book_amount = (int)$quantity;
                        $deliveryItem->is_delivered_flag = 1;
                        $deliveryItem->delivery_id = $nextDeliveryId;
                        // リードタイム計算: 納品日を指定日で計算
                        $deliveryDateObj = new \DateTime($deliveryDate);
                        $orderDateObj = new \DateTime($order->order_date);
                        $deliveryItem->leadTime = $orderDateObj->diff($deliveryDateObj)->days;
                        $deliveryItemsTable->save($deliveryItem);
                    }
                }
            }
            $connection->commit();
            $this->Flash->success('納品登録が完了しました。');
            return $this->redirect(['action' => 'selectCustomer']);
        } catch (\Exception $e) {
            $connection->rollback();
            $this->Flash->error('エラーが発生しました: ' . $e->getMessage());
        }
    }
}
