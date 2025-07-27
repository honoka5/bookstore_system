<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文書詳細</title>
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
            color: #000000;
        }
        .info-list p {
            margin: 6px 0;
            font-size: 15px;
            color: #000000;
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
            text-align: center;
        }
        th {
            background: #e3f2fd;
            font-weight: bold;
            color: #000000;
        }
        tfoot td {
            background: #f9f9f9;
            font-weight: bold;
        }
        .button-area {
            margin-top: 24px;
            display: flex;
            gap: 24px;
            justify-content: flex-start;
        }
        .button, .action-btn {
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 32px;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .button:hover, .action-btn:hover {
            background-color: #5a6268;
        }
        .action-btn {
            background-color: #1976d2;
        }
        .action-btn:hover {
            background-color: #1565c0;
        }
        @media print {
            @page {
                margin: 1cm;
                size: A4;
            }
            html, body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            body {
                background-color: white;
                margin: 0;
                padding: 0;
                padding-top: 0 !important;
            }
            .main-container {
                max-width: none;
                margin: 0;
                background: white;
                border-radius: 0;
                box-shadow: none;
                padding: 20px;
            }
            h2 {
                color: black;
            }
            th {
                background: #f0f0f0 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            tfoot td {
                background: #f5f5f5 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            .button-area {
                display: none !important;
            }
            .button, .action-btn {
                display: none !important;
            }
        }
    </style>
    <script>
        function printDocument() {
            const originalTitle = document.title;
            document.title = '';
            const printStyle = document.createElement('style');
            printStyle.innerHTML = `
                @media print {
                    @page {
                        margin: 1cm;
                        size: A4;
                    }
                    html, body {
                        -webkit-print-color-adjust: exact;
                        color-adjust: exact;
                    }
                }
            `;
            document.head.appendChild(printStyle);
            setTimeout(() => {
                window.print();
                setTimeout(() => {
                    document.title = originalTitle;
                    document.head.removeChild(printStyle);
                }, 100);
            }, 100);
        }
    </script>
</head>
<body>
    <?= $this->element('common_header') ?>
    <div class="main-container">
        <h2>注文書詳細</h2>
        <div class="info-list">
            <p>注文書ID: <?= h($order->order_id) ?></p>
            <p>顧客ID: <?= h($order->customer_id) ?></p>
            <p>顧客名: <?= h($order->customer->name ?? '') ?></p>
            <p>注文日: <?= h($order->order_date) ?></p>
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
            <div style="margin-top:18px;">
                <p>備考: <?= h($order->remark) ?></p>
            </div>
        <div class="button-area">
            <?= $this->Html->link('戻る', ['controller' => 'List', 'action' => 'order'], ['class' => 'button']) ?>
            <?= $this->Html->link('編集', ['controller' => 'OrderList', 'action' => 'editOrderDetail', $order->order_id], ['class' => 'action-btn']) ?>
        </div>
    </div>
</body>
</html>
