<h1>注文入力</h1>
<?= $this->Form->create(null) ?>
<table>
    <tr>
        <th>書籍名</th>
        <th>単価</th>
        <th>数量</th>
        <th>摘要</th>
    </tr>
    <?php for ($i = 0; $i < 15; $i++): ?>
        <tr>
            <td><?= $this->Form->control("order_items.$i.book_name", ['label' => false]) ?></td>
            <td><?= $this->Form->control("order_items.$i.unit_price", ['label' => false]) ?></td>
            <td><?= $this->Form->control("order_items.$i.book_amount", ['label' => false]) ?></td>
            <td><?= $this->Form->control("order_items.$i.book_summary", ['label' => false]) ?></td>
        </tr>
    <?php endfor; ?>
    <td colspan=4><?= $this->Form->control("orders.remark", ['label' => '備考']) ?></td>
</table>
<div class="form-buttons">
    <div class="left-btn">
        <?= $this->Html->link('戻る', ['controller' => 'RegOrders', 'action' => 'selectCustomer'], ['class' => 'button']) ?>
    </div>
    <div class="right-btn">
        <?= $this->Form->button('登録', ['class' => 'button']) ?>
    </div>
</div>
<?= $this->Form->end() ?>

<style>
    .form-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .left-btn {
        flex: 1;
        text-align: left;
    }

    .right-btn {
        flex: 1;
        text-align: right;
    }
</style>