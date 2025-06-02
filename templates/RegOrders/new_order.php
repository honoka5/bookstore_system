<h1>注文入力</h1>
<?= $this->Form->create(null) ?>
<table>
    <tr><th>書籍名</th><th>単価</th><th>数量</th></tr>
    <?php for ($i = 0; $i < 10; $i++): ?>
    <tr>
        <td><?= $this->Form->control("order_items.$i.book_title", ['label' => false]) ?></td>
        <td><?= $this->Form->control("order_items.$i.unit_price", ['label' => false]) ?></td>
        <td><?= $this->Form->control("order_items.$i.book_amount", ['label' => false]) ?></td>
    </tr>
    <?php endfor; ?>
</table>
<?= $this->Form->button('登録') ?>
<?= $this->Form->end() ?>
