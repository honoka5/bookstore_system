<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBS注文管理画面</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background-color: #f5f5f5;
        }

        .main-content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            min-height: calc(100vh - 60px);
        }

        h1 {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .action-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .new-button {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.2s;
        }

        .new-button:hover {
            background: #0056b3;
        }

        .filter-form {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
        }

        .filter-form form {
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
        }

        .filter-form input {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            width: 300px;
        }

        .filter-form button {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            padding: 8px 16px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .filter-form button:hover {
            background: #218838;
        }

        .table-container {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
        }

        .scroll-table {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 60vh;
        }

        table {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            width: 100%;
            border-collapse: collapse;
            background: white;
            min-width: 900px;
        }

        table th,
        table td {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            white-space: nowrap;
        }

        table th {
            background: #f8f9fa;
            font-weight: bold;
            color: #495057;
            position: sticky;
            top: 0;
            z-index: 2;
        }

        table tbody tr:hover {
            background: #f8f9fa;
        }

        table tbody tr.selected {
            background: #007bff !important;
            color: white;
        }

        table tbody tr.selected td {
            background: #007bff !important;
            color: white;
        }

        .delete-btn {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.2s;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        .button-section {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 32px;
        }

        .back-button a {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background 0.2s;
        }

        .back-button a:hover {
            background-color: #5a6268;
        }

        .detail-button {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .detail-button:hover {
            background-color: #0056b3;
        }

        .no-data {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            text-align: center;
            color: #6c757d;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 4px;
            margin: 20px 0;
        }

        .no-data h3 {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            font-weight: bold;
        }

        /* Flash メッセージのスタイル */
        .flash-message {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            padding: 12px;
            border-radius: 4px;
            margin: 20px 0;
        }

        .flash-message.success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .flash-message.error {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .flash-message.warning {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }

        .flash-message.info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }

        @media screen and (max-width: 900px) {
            table {
                font-size: 14px;
                min-width: 400px;
            }
            .main-content {
                padding: 10px;
            }
        }

        @media screen and (max-width: 600px) {
            table {
                font-size: 12px;
                min-width: 320px;
            }
            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- 共通ヘッダーを読み込み -->
    <?= $this->element('common_header') ?>

    <div class="main-content">
        <h1>注文書一覧</h1>
        
        <!-- Flash メッセージ表示 -->
        <?= $this->Flash->render() ?>

        <!-- 新規作成ボタン -->
        <div class="action-section">
            <?= $this->Html->link('新規作成', ['controller' => 'RegOrders', 'action' => 'select_customer'], ['class' => 'new-button']) ?>
        </div>
        
        <!-- 検索フォーム -->
        <div class="filter-form">
            <form method="get">
                <input type="text" name="keyword" placeholder="検索キーワード" value="<?= h($keyword ?? '') ?>">
                <button type="submit">検索</button>
            </form>
        </div>

        <?php if (!empty($orders)): ?>
            <div class="table-container">
                <div class="scroll-table">
                    <table id="orderTable">
                        <thead>
                            <tr>
                                <th>注文書ID</th>
                                <th>顧客ID</th>
                                <th>顧客名</th>
                                <th>金額</th>
                                <th>注文日</th>
                                <th>削除</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders ?? [] as $order): ?>
                            <tr>
                                <td><?= h($order->order_id) ?></td>
                                <td><?= h($order->customer_id) ?></td>
                                <td><?= h($order->customer->name ?? '') ?></td>
                                <td><?= h($order->total_amount ?? '') ?></td>
                                <td><?= h($order->order_date) ?></td>
                                <td>
                                    <?= $this->Form->create(null, [
                                        'url' => ['controller'=>'OrderList','action'=>'deleteOrder', h($order->order_id)],
                                        'style' => 'display:inline;',
                                        'type' => 'post',
                                    ]) ?>
                                        <button type="submit" class="delete-btn" title="削除" onclick="return confirm('本当に削除しますか？');">削除</button>
                                    <?= $this->Form->end() ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="no-data">
                <h3>データがありません</h3>
                <p>注文書データが見つかりませんでした。</p>
            </div>
        <?php endif; ?>

        <div class="button-section">
            <div class="back-button">
                <?= $this->Html->link('戻る', ['controller' => 'Home', 'action' => 'index']) ?>
            </div>
            <button class="detail-button" id="detailBtn" type="button">詳細</button>
        </div>
    </div>

    <script>
        // 行選択
        document.addEventListener('DOMContentLoaded', function() {
            const orderDetailBaseUrl = <?= json_encode(rtrim($this->Url->build(["controller" => "OrderList", "action" => "orderDetail"]), '/')) ?>;
            const rows = document.querySelectorAll('#orderTable tbody tr');
            
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    if (!this.cells[0].textContent.trim()) return;
                    rows.forEach(r => r.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
            
            // 詳細ボタン
            document.getElementById('detailBtn').addEventListener('click', function() {
                const selectedRow = document.querySelector('#orderTable tr.selected');
                if (selectedRow && selectedRow.cells[0].textContent.trim()) {
                    const orderId = selectedRow.cells[0].textContent.trim();
                    window.location.href = orderDetailBaseUrl + '/' + encodeURIComponent(orderId);
                } else {
                    alert('項目を選択してください');
                }
            });
        });
    </script>
</body>
</html>