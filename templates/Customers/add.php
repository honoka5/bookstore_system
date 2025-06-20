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
<hr>

<h2>Excelで一括登録</h2>
<?= $this->Form->create(null, ['type' => 'file']) ?>
    <?= $this->Form->control('excel_file', ['type' => 'file', 'label' => 'Excelファイル']) ?>
    <?= $this->Form->hidden('excel_upload', ['value' => 1]) ?>
    <?= $this->Form->button('Excelアップロード') ?>
<?= $this->Form->end() ?>

<?= $this->Html->link('一覧に戻る',['controller' => 'List', 'action' => 'customer'], ['class' => 'button']) ?>