<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Customer> $customers
 */
?>
<div class="customers index content">
    <?= $this->Html->link(__('New Customer'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Customers') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('Name') ?></th>
                    <th><?= $this->Paginator->sort('Address') ?></th>
                    <th><?= $this->Paginator->sort('Phone_Number') ?></th>
                    <th><?= $this->Paginator->sort('Contact_Person') ?></th>
                    <th><?= $this->Paginator->sort('Delivery_Conditions') ?></th>
                    <th><?= $this->Paginator->sort('Customer_Registration_Date') ?></th>
                    <th><?= $this->Paginator->sort('remark') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= $this->Number->format($customer->id) ?></td>
                    <td><?= h($customer->Name) ?></td>
                    <td><?= h($customer->Address) ?></td>
                    <td><?= h($customer->Phone_Number) ?></td>
                    <td><?= h($customer->Contact_Person) ?></td>
                    <td><?= h($customer->Delivery_Conditions) ?></td>
                    <td><?= h($customer->Customer_Registration_Date) ?></td>
                    <td><?= h($customer->remark) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $customer->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $customer->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $customer->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $customer->id),
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