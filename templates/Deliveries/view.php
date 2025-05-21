<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Delivery $delivery
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Delivery'), ['action' => 'edit', $delivery->delivery_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Delivery'), ['action' => 'delete', $delivery->delivery_id], ['confirm' => __('Are you sure you want to delete # {0}?', $delivery->delivery_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Deliveries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Delivery'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="deliveries view content">
            <h3><?= h($delivery->delivery_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Delivery Id') ?></th>
                    <td><?= h($delivery->delivery_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Order Number') ?></th>
                    <td><?= h($delivery->order_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Order') ?></th>
                    <td><?= $delivery->hasValue('order') ? $this->Html->link($delivery->order->order_id, ['controller' => 'Orders', 'action' => 'view', $delivery->order->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Cutomer Id') ?></th>
                    <td><?= h($delivery->cutomer_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Delivery Total') ?></th>
                    <td><?= $this->Number->format($delivery->delivery_total) ?></td>
                </tr>
                <tr>
                    <th><?= __('Delivery Date') ?></th>
                    <td><?= h($delivery->delivery_date) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>