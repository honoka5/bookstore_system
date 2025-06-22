<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<h1>顧客登録</h1>
<h2>Excelで一括登録</h2>
<?= $this->Form->create(null, ['type' => 'file']) ?>
    <?= $this->Form->control('excel_file', ['type' => 'file', 'label' => 'Excelファイル']) ?>
    <?= $this->Form->hidden('excel_upload', ['value' => 1]) ?>
    <?= $this->Form->button('Excelアップロード') ?>
<?= $this->Form->end() ?>

<?= $this->Html->link('一覧に戻る',['controller' => 'List', 'action' => 'customer'], ['class' => 'button']) ?>