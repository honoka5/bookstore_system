<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Delivery $delivery
 * @var array $orders
 * @var string $keyword
 * @var array $orderList
 */
?>
<h1>納品書作成</h1>

<div class="deliveries add content">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#">納品書作成</a></li>
        <li><a href="#">ホーム›納品書作成</a></li>
    </ul>
    <div style="margin-top:20px;">
        <h3>注文書を選択してください</h3>
        <?= $this->Form->create(null, ['type' => 'get']) ?>
        <label>顧客名：</label>
        <?= $this->Form->control('keyword', ['label' => false, 'value' => $keyword ?? '', 'placeholder' => '顧客名', 'style' => 'display:inline;width:200px;']) ?>
        <?= $this->Form->button('検索', ['type' => 'submit', 'style' => 'margin-left:10px;']) ?>
        <?= $this->Form->end() ?>

        <?php if (!empty($orderList)): ?>
            <form method="post" action="<?= $this->Url->build(['action' => 'add']) ?>">
                <table border="1" style="width:100%;margin-top:20px;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>顧客名</th>
                            <th>金額</th>
                            <th>注文日</th>
                            <th>注文書ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderList as $order): ?>
                            <tr>
                                <td><input type="radio" name="order_id" value="<?= h($order['order_id']) ?>" <?= (!empty($selectedOrderId) && $selectedOrderId == $order['order_id']) ? 'checked' : '' ?>></td>
                                <td><?= h($order['customer_name']) ?></td>
                                <td><?= h($order['amount']) ?></td>
                                <td><?= h($order['order_date']) ?></td>
                                <td><?= h($order['order_id']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="margin-top:20px;">
                    <button type="button" onclick="window.history.back();">戻る</button>
                    <button type="submit" style="float:right;">次へ</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>