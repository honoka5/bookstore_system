<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<h1>顧客登録</h1>
<?= $this->Form->create($customer) ?>
    <?= $this->Form->control('name', ['label' => '顧客名']) ?>
    <?= $this->Form->control('phone_number', ['label' => '電話番号']) ?>
    <?= $this->Form->control('contact_person', ['label' => '担当者名']) ?>
    <?= $this->Form->button('登録') ?>
<?= $this->Form->end() ?>
<?= $this->Html->link('一覧に戻る', ['action' => 'index'], ['class' => 'button']) ?>