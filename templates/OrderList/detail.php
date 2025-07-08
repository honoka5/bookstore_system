<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文書詳細</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #888; padding: 4px 8px; }
        th { background: #eee; }
        .button-section {
            display: flex;
            justify-content: space-between; /* 両端に配置 */
            align-items: center;
            gap: 16px;
            margin-top: 16px;
        }
        .button {
            background-color: #1976d2;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 8px 32px;
            font-size: 20px;
            cursor: pointer;
            height: 44px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }
        .button:hover {
            background: #1565c0;
        }
    </style>
</head>
<body>
    <h2>注文書詳細</h2>
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
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order->order_items as $item): ?>
            <tr>
                <td><?= h($item->book_title) ?></td>
                <td><?= h($item->book_amount) ?></td>
                <td><?= h($item->unit_price) ?></td>
                <td><?= h($item->book_summary) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    

    <div class="button-section">
        <?= $this->Html->link('戻る', ['controller' => 'List', 'action' => 'order'], ['class' => 'button']) ?>
        <?= $this->Html->link('編集', ['controller' => 'OrderList', 'action' => 'editOrderDetail', $order->order_id], ['class' => 'button']) ?>
    </div>
</body>
</html>
