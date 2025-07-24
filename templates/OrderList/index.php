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
            background-color: #f0f2f5;
            overflow: hidden; /* 外スクロール無効 */
        }

        .main-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            height: calc(100vh - 60px);
            overflow: hidden; /* 外スクロール無効 */
            display: flex;
            flex-direction: column;
        }

        .content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        h1 {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
            flex-shrink: 0;
        }

        .action-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
            flex-shrink: 0;
        }

        .button {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background: #27ae60;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(39, 174, 96, 0.3);
        }

        .button:hover {
            background: #229954;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(39, 174, 96, 0.4);
        }

        .search-section {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e9ecef;
            flex-shrink: 0;
        }

        .search-section form {
            display: flex;
            align-items: center;
            gap: 12px;
            justify-content: center;
        }

        .search-input {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            padding: 8px 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            width: 300px;
            transition: border-color 0.2s;
        }

        .search-input:focus {
            outline: none;
            border-color: #27ae60;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.1);
        }

        .search-btn {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            padding: 8px 16px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(39, 174, 96, 0.3);
        }

        .search-btn:hover {
            background: #229954;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(39, 174, 96, 0.4);
        }

        .table-container {
            margin-bottom: 20px;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            overflow: hidden;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .scroll-table {
            overflow-x: auto;
            overflow-y: auto;
            flex: 1;
            min-height: 0;
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
            border-bottom: 1px solid #e9ecef;
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
            background: #3498db !important;
            color: white;
        }

        table tbody tr.selected td {
            background: #3498db !important;
            color: white;
        }

        .delete-btn {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 4px 8px;
            cursor: pointer;
            font-size: 12px;
            transition: background 0.2s;
        }

        .delete-btn:hover {
            background: #c0392b;
        }

        .button-section {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 20px;
            flex-shrink: 0;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }

        .back-button a {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background-color: #6c7b7f;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(108, 123, 127, 0.3);
        }

        .back-button a:hover {
            background-color: #5a6c70;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(108, 123, 127, 0.4);
        }

        .detail-button {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);
        }

        .detail-button:hover {
            background-color: #2980b9;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(52, 152, 219, 0.4);
        }

        .no-data {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            text-align: center;
            color: #7f8c8d;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 6px;
            margin: 20px 0;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .no-data h3 {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Flash メッセージのスタイル */
        .flash-message {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            padding: 12px;
            border-radius: 6px;
            margin: 20px 0;
            flex-shrink: 0;
        }

        .flash-message.success {
            background: #d5f4e6;
            border: 1px solid #27ae60;
            color: #1e8449;
        }

        .flash-message.error {
            background: #fadbd8;
            border: 1px solid #e74c3c;
            color: #c0392b;
        }

        .flash-message.warning {
            background: #fcf3cf;
            border: 1px solid #f39c12;
            color: #d68910;
        }

        .flash-message.info {
            background: #d6eaf8;
            border: 1px solid #3498db;
            color: #2874a6;
        }

        @media screen and (max-width: 900px) {
            table {
                font-size: 14px;
                min-width: 400px;
            }
            .main-container {
                padding: 15px;
            }
            .search-input {
                width: 250px;
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
            .search-section form {
                flex-direction: column;
                gap: 10px;
            }
            .search-input {
                width: 100%;
            }
            .button-section {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <?= $this->element('common_header') ?>
    <div class="main-container">
        <div class="content-area">
            <!-- New Create Button -->
            <div style="display: flex; justify-content: flex-end; margin-bottom: 18px;">
                <?= $this->Html->link('新規作成', ['controller' => 'RegOrders', 'action' => 'select_customer'], ['class' => 'button', 'style' => 'font-size:20px; padding: 0 32px; height: 44px;']) ?>
            </div>
            <!-- Search Section -->
            <div class="search-section" style="margin-top: 10px;">
            <form method="get" class="search-section" style="margin-top: 10px;">
                <input type="text" name="keyword" class="search-input" placeholder="検索キーワード" value="<?= h($keyword ?? '') ?>">
                <button type="submit" class="search-btn">検索</button>
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