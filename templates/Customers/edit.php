<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $customer->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Customers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="customers form content">
            <?= $this->Form->create($customer) ?>
            <fieldset>
                <legend><?= __('Edit Customer') ?></legend>
                <?php
                    echo $this->Form->control('Name');
                    echo $this->Form->control('Address');
                    echo $this->Form->control('Phone_Number');
                    echo $this->Form->control('Contact_Person');
                    echo $this->Form->control('Delivery_Conditions');
                    echo $this->Form->control('Customer_Registration_Date');
                    echo $this->Form->control('remark');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
