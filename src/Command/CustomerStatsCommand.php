<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\BaseCommand;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\I18n\Date;
use Cake\Datasource\Exception\MissingTableException;
use Cake\ORM\TableRegistry;

class CustomerStatsCommand extends BaseCommand
{
    public function buildOptionParser(ConsoleOptionParser $parser): ConsoleOptionParser
    {
        $parser->setDescription('顧客統計情報を日次で自動計算・保存します');
        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io)
    {
        $io->out('顧客統計情報の自動計算を開始します...');
        $customersTable = TableRegistry::getTableLocator()->get('Customers');
        $statsTable = TableRegistry::getTableLocator()->get('Statistics');
        try {
            $deliveriesTable = TableRegistry::getTableLocator()->get('Deliveries');
        } catch (\Exception $e) {
            $io->err('テーブル取得エラー: ' . $e->getMessage());
            return 1;
        }
        $deliveryItemsTable = TableRegistry::getTableLocator()->get('DeliveryItems');
        $orderItemsTable = TableRegistry::getTableLocator()->get('OrderItems');
        $ordersTable = TableRegistry::getTableLocator()->get('Orders');
        $now = Date::now();
        $today = $now->format('Y-m-d');
        $customers = $customersTable->find()->all();
        $count = 0;
        foreach ($customers as $customer) {
            $customerId = $customer->customer_id;
            // 既に本日分が計算済みならスキップ
            $stat = $statsTable->find()->where(['customer_id' => $customerId, 'calc_date' => $today])->first();
            if ($stat) continue;
            $orderIds = $ordersTable->find()->select(['order_id'])->where(['customer_id' => $customerId])->all()->extract('order_id')->toArray();
            if (empty($orderIds)) continue;
            $deliveryIds = $deliveriesTable->find()->select(['delivery_id'])->where(['customer_id' => $customerId])->all()->extract('delivery_id')->toArray();
            if (empty($deliveryIds)) {
                $totalAmount = 0;
            } else {
                $deliveredItems = $deliveryItemsTable->find()
                    ->where(['delivery_id IN' => $deliveryIds, 'is_delivered_flag' => true])
                    ->all();
                $totalAmount = 0;
                foreach ($deliveredItems as $item) {
                    $totalAmount += $item->unit_price * $item->book_amount;
                }
            }
            $totalLeadTime = 0;
            $totalQuantity = 0;
            $orderItemIds = $orderItemsTable->find()->select(['orderItem_id'])->where(['order_id IN' => $orderIds])->all()->extract('orderItem_id')->toArray();
            if (!empty($orderItemIds)) {
                $deliveryItems = $deliveryItemsTable->find()->where(['orderItem_id IN' => $orderItemIds])->all();
                foreach ($deliveryItems as $item) {
                    if ($item->is_delivered_flag) {
                        $leadTime = $item->leadTime ?? 0;
                        $totalLeadTime += $leadTime * $item->book_amount;
                        $totalQuantity += $item->book_amount;
                    } else {
                        $calcDate = $now;
                        $orderItemId = $item->orderItem_id;
                        $orderItem = $orderItemsTable->find()->select(['order_id'])->where(['orderItem_id' => $orderItemId])->first();
                        if ($orderItem) {
                            $orderId = $orderItem->order_id;
                            $order = $ordersTable->find()->select(['order_date'])->where(['order_id' => $orderId])->first();
                            if ($order) {
                                $orderDate = $order->order_date;
                                $leadTime = $calcDate->diffInDays($orderDate);
                                $totalLeadTime += $leadTime * $item->book_amount;
                                $totalQuantity += $item->book_amount;
                            }
                        }
                    }
                }
            }
            $avgLeadTime = $totalQuantity > 0 ? round($totalLeadTime / $totalQuantity, 2) : 0;
            if (!$stat) {
                $stat = $statsTable->newEntity(['customer_id' => $customerId]);
            }
            $stat->total_purchase_amt = $totalAmount;
            $stat->avg_lead_time = $avgLeadTime;
            $stat->calc_date = $now;
            $statsTable->save($stat);
            $count++;
        }
        $io->out("計算・保存完了: {$count}件");
    }
}
