<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文書詳細（編集）</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #888; padding: 4px 8px; }
        th { background: #eee; }
        .button-area {
            position: fixed;
            right: 30px;
            bottom: 30px;
            margin-top: 0;
            text-align: right;
            z-index: 100;
        }
        .btn, .button { background-color: #1976d2; color: #fff; border: none; border-radius: 4px; padding: 6px 24px; font-size: 13px; cursor: pointer; }
        .btn:active, .button:active { background: #1565c0; }
        .delete-btn { background: #e53935; color: #fff; border-radius: 4px; padding: 2px 10px; font-size: 15px; cursor: pointer; }
        .delete-btn:active { background: #b71c1c; }
    </style>
</head>
<body>
    <h2>注文書詳細（編集）</h2>
    <?= $this->Form->create(null, ['type' => 'post', 'id' => 'main-edit-form']) ?>
    <p>注文書ID: <?= h($order->order_id) ?></p>
    <p>顧客ID: <?= h($order->customer_id) ?></p>
    <p>顧客名: <?= h($order->customer->name ?? '') ?></p>
    <p>注文日: <?= h($order->order_date) ?></p>
    <p>備考: <?= $this->Form->control('remark', ['type'=>'text', 'value'=>$order->remark, 'label'=>false, 'style'=>'width:300px;']) ?></p>
    <?= $this->Form->end() ?>

    <table>
        <thead>
            <tr>
                <th>書籍名</th>
                <th>数量</th>
                <th>単価</th>
                <th>摘要</th>
                <th>削除</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order->order_items as $item): ?>
            <tr>
                <td><?= $this->Form->text("book_title[{$item->orderItem_id}]", [
                    'value' => $item->book_title,
                    'style' => 'width:140px;',
                    'required' => true,
                    'placeholder' => '書籍名',
                    'form' => null // 編集用form外
                ]) ?></td>
                <td>
                    <?= $this->Form->select("book_amount[{$item->orderItem_id}]", $amountRanges[$item->orderItem_id], [
                        'value' => $item->book_amount,
                        'empty' => false,
                        'style' => 'width:60px;',
                        'form' => null
                    ]) ?>
                    <?= $this->Form->text("book_amount[{$item->orderItem_id}]", [
                        'value' => $item->book_amount,
                        'style' => 'width:50px;',
                        'pattern' => '[0-9]*',
                        'inputmode' => 'numeric',
                        'title' => '数量を直接入力できます',
                        'form' => null
                    ]) ?>
                </td>
                <td><?= $this->Form->text("unit_price[{$item->orderItem_id}]", ['value'=>$item->unit_price, 'style'=>'width:70px;', 'form' => null]) ?></td>
                <td><?= $this->Form->text("book_summary[{$item->orderItem_id}]", ['value'=>$item->book_summary, 'style'=>'width:120px;', 'form' => null]) ?></td>
                <td>
                    <form method="post" action="<?= $this->Url->build(['controller'=>'OrderList','action'=>'deleteOrderItem', $item->orderItem_id]) ?>" style="display:inline;">
                        <input type="hidden" name="_csrfToken" value="<?= h($this->request->getAttribute('csrfToken')) ?>">
                        <button type="submit" class="delete-btn" title="削除" onclick="return confirm('本当に削除しますか？');">&#10005;</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="button-area">
        <?= $this->Html->link('戻る', ['controller' => 'OrderList', 'action' => 'orderDetail', $order->order_id], ['class' => 'button']) ?>
        <button type="submit" form="main-edit-form" class="btn">確定</button>
    </div>
</body>
</html>
