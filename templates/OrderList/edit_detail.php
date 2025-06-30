<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文書詳細（編集）</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #888; padding: 4px 8px; }
        th { background: #eee; }
        .button-area { margin-top: 20px; text-align: right; }
        .btn, .button { background-color: #1976d2; color: #fff; border: none; border-radius: 4px; padding: 6px 24px; font-size: 13px; cursor: pointer; }
        .btn:active, .button:active { background: #1565c0; }
        .delete-btn { background: #e53935; color: #fff; border-radius: 4px; padding: 2px 10px; font-size: 15px; cursor: pointer; }
        .delete-btn:active { background: #b71c1c; }
    </style>
</head>
<body>
    <h2>注文書詳細（編集）</h2>
    <p>注文書ID: <?= h($order->order_id) ?></p>
    <p>顧客ID: <?= h($order->customer_id) ?></p>
    <p>顧客名: <?= h($order->customer->name ?? '') ?></p>
    <p>注文日: <?= h($order->order_date) ?></p>
    <p>備考: <?= h($order->remark) ?></p>

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
                <td><?= h($item->book_title) ?></td>
                <td><?= h($item->book_amount) ?></td>
                <td><?= h($item->unit_price) ?></td>
                <td><?= h($item->book_summary) ?></td>
                <td>
                    <?= $this->Form->create(null, [
                        'url' => ['controller'=>'OrderList','action'=>'deleteOrderItem', h($item->orderItem_id)],
                        'style' => 'display:inline;',
                        'type' => 'post',
                    ]) ?>
                        <button type="submit" class="delete-btn" title="削除" onclick="return confirm('本当に削除しますか？');">&#10005;</button>
                    <?= $this->Form->end() ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="button-area">
        <?= $this->Html->link('戻る', ['controller' => 'OrderList', 'action' => 'orderDetail', $order->order_id], ['class' => 'button']) ?>
    </div>
</body>
</html>
