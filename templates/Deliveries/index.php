<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Delivery> $deliveries
 */
?>
<div class="deliveries index content">
    <?= $this->Html->link(__('納品書作成'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('納品書画面') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('納品書ID') ?></th>
                    <th><?= $this->Paginator->sort('注文書番号') ?></th>
                    <th><?= $this->Paginator->sort('注文書ID') ?></th>
                    <th><?= $this->Paginator->sort('納品書一覧') ?></th>
                    <th><?= $this->Paginator->sort('納品書ID') ?></th>
                    <th><?= $this->Paginator->sort('お客様ID') ?></th>
                    <th class="actions"><?= __('Actions？') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($deliveries as $delivery): ?>
                <tr>
                    <td><?= h($delivery->delivery_id) ?></td>
                    <td><?= h($delivery->order_number) ?></td>
                    <td><?= $delivery->hasValue('order') ? $this->Html->link($delivery->order->order_id, ['controller' => 'Orders', 'action' => 'view', $delivery->order->id]) : '' ?></td>
                    <td><?= $this->Number->format($delivery->delivery_total) ?></td>
                    <td><?= h($delivery->delivery_date) ?></td>
                    <td><?= h($delivery->cutomer_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $delivery->delivery_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $delivery->delivery_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $delivery->delivery_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $delivery->delivery_id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>