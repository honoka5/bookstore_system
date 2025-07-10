<h1>注文入力</h1>
<div style="display:flex; justify-content:space-between; align-items:center;">
    <div></div>
    <div style="text-align:right;">
        <label for="order_date">注文日:</label>
        <input type="date" name="order_date" id="order_date" value="<?= h(date('Y-m-d')) ?>" style="margin-left:5px;">
    </div>
</div>
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
            <td><?= $this->Form->control("order_items.{$i}.book_title", ['label' => false]) ?></td>
            <td><?= $this->Form->control("order_items.{$i}.unit_price", [
                'label' => false,
                'type' => 'number',
                'min' => 1,
                'max' => 9999999,
                'inputmode' => 'numeric',
            ]) ?></td>
            <td><?= $this->Form->control("order_items.{$i}.book_amount", [
                'label' => false,
                'type' => 'number',
                'min' => 1,
                'max' => 999,
                'inputmode' => 'numeric',
            ]) ?></td>
            <td><?= $this->Form->control("order_items.{$i}.book_summary", ['label' => false]) ?></td>
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

<?php $flashMsg = $this->Flash->render(); ?>
<script>
<?php if (!empty($flashMsg)): ?>
    window.onload = function() {
        alert('<?= strip_tags(trim($flashMsg)) ?>');
    };
<?php endif; ?>
</script>

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
    /* 単価のスピンボタン非表示 */
    input[type=number][name*='unit_price']::-webkit-outer-spin-button,
    input[type=number][name*='unit_price']::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number][name*='unit_price'] {
        -moz-appearance: textfield;
    }
</style>