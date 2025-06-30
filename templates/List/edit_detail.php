<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 * @var \App\Model\Entity\OrderItem[]|\Cake\Collection\CollectionInterface $orderItems
 */
?>
<div class="orders view content">
    <h3><?= h($order->order_id) ?></h3>
    <table>
        <tr>
            <th><?= __('Order ID') ?></th>
            <td><?= h($order->order_id) ?></td>
        </tr>
        <tr>
            <th><?= __('Customer Name') ?></th>
            <td><?= h($order->customer_name) ?></td>
        </tr>
        <tr>
            <th><?= __('Order Date') ?></th>
            <td><?= h($order->order_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($order->status) ?></td>
        </tr>
    </table>
    <h4><?= __('Order Items') ?></h4>
    <table>
        <thead>
            <tr>
                <th><?= __('Product') ?></th>
                <th><?= __('Quantity') ?></th>
                <th><?= __('Price') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderItems as $item): ?>
            <tr>
                <td><?= h($item->product_name) ?></td>
                <td><?= h($item->quantity) ?></td>
                <td><?= h($item->price) ?></td>
                <td>
                    <?= $this->Form->create(null, [
                        'url' => ['controller'=>'OrderList','action'=>'deleteOrderItem', h($item->orderItem_id)],
                        'style' => 'display:inline;',
                        'type' => 'post',
                    ]) ?>
                        <button type="submit" class="delete-btn" title="削除" onclick="return confirm('本当に削除しますか？');">&#10005;</button>
                    <?= $this->Form->end() ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="button-area">
        <?= $this->Html->link('戻る', ['controller' => 'OrderList', 'action' => 'orderDetail', $order->order_id], ['class' => 'button']) ?>
    </div>
</div>