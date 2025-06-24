<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>納品書詳細</title>
    <style>
        body {
            font-family: "MS UI Gothic", sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .main-container {
            max-width: 700px;
            margin: 32px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
            padding: 32px;
        }
        h2 {
            margin-top: 0;
            color: #1976d2;
        }
        .info-list p {
            margin: 6px 0;
            font-size: 15px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 18px;
        }
        th, td {
            border: 1px solid #888;
            padding: 6px 10px;
            font-size: 14px;
        }
        th {
            background: #e3f2fd;
        }
        .button-area {
            margin-top: 24px;
            text-align: right;
        }
        .button {
            background-color: #1976d2;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 32px;
            font-size: 15px;
            cursor: pointer;
        }
        .button:hover {
            background-color: #1565c0;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <h2>納品書詳細</h2>
        <div class="info-list">
            <p>納品書ID: <?= h($delivery->delivery_id) ?></p>
            <p>顧客ID: <?= h($delivery->customer_id) ?></p>
            <p>顧客名: <?= h($delivery->customer->name ?? '') ?></p>
            <p>納品日: <?= h($delivery->delivery_date) ?></p>
            <p>備考: <?= h($delivery->remark ?? '') ?></p>
        </div>
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
                <?php foreach ($delivery->delivery_items ?? [] as $item): ?>
                <tr>
                    <td><?= h($item->book_title) ?></td>
                    <td><?= h($item->book_amount) ?></td>
                    <td><?= h($item->unit_price) ?></td>
                    <td><?= h($item->book_summary) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="button-area">
            <?= $this->Html->link('戻る', ['controller' => 'DeliveryList', 'action' => 'index'], ['class' => 'button']) ?>
        </div>
    </div>
</body>
</html>