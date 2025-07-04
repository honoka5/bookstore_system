
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBS注文管理画面</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: "MS UI Gothic", sans-serif;
            background-color: #f8f9fa;
        }
        .main-container {
            max-width: 1400px;
            min-height: 100vh;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
        }
        .header-tabs {
            display: flex;
            border-bottom: 1px solid #808080;
            background: #1976d2;
            color: #fff;
            border-radius: 0;
            padding: 18px 16px 18px 16px;
            font-size: 36px;
            font-weight: bold;
            justify-content: center;
            letter-spacing: 6px;
        }
        .content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 32px 32px 16px 32px;
            background-color: #fff;
        }
        .search-section {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 24px;
            gap: 12px;
        }
        .search-input {
            border: 2px solid #b39ddb;
            padding: 0 12px;
            font-size: 20px;
            height: 40px;
            width: 600px;
            border-radius: 6px;
            background-color: white;
        }
        .search-btn {
            background-color: #e53935;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 0 24px;
            font-size: 20px;
            height: 40px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }
        .search-btn:active,
        .search-btn:hover {
            background: #b71c1c;
        }
        .table-container {
            flex: 1;
            background-color: white;
            border: 1px solid #808080;
            border-radius: 6px;
            margin-bottom: 24px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .scroll-table {
            flex: 1;
            overflow-y: auto;
            overflow-x: auto;
            max-height: 60vh;
        }
        .data-table {
            width: 96%;
            margin: 0 auto;
            border-collapse: collapse;
            font-size: 20px;
            min-width: 900px;
        }
        .data-table th, .data-table td {
            border: 1px solid #e0e0e0;
            padding: 14px 8px;
            text-align: left;
            white-space: nowrap;
        }
        .data-table th {
            background: #f5f5f5;
            font-weight: bold;
            position: sticky;
            top: 0;
            z-index: 2;
        }
        .data-table tr.selected {
            background: #1976d2 !important;
            color: #fff;
        }
        .data-table tr.selected td {
            background: #1976d2 !important;
            color: #fff;
        }
        .data-table tr:not(.selected):hover td {
            background: #e6f3ff;
        }
        .button-section {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            margin-top: 16px;
        }
        .btn, .button {
            background-color: #1976d2;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 8px 32px;
            font-size: 20px;
            cursor: pointer;
            height: 44px;
            font-weight: bold;
        }
        .btn:active, .button:active,
        .btn:hover, .button:hover {
            background: #1565c0;
        }
        .delete-btn {
            background: #e53935;
            font-size: 18px;
            padding: 0 14px;
            height: 36px;
            border-radius: 6px;
        }
        .delete-btn:hover {
            background: #b71c1c;
        }
        @media screen and (max-width: 900px) {
            .data-table {
                font-size: 14px;
                min-width: 400px;
            }
            .content-area {
                padding: 8px;
            }
            .main-container {
                max-width: 100vw;
            }
        }
        @media screen and (max-width: 600px) {
            .main-container {
                width: 100vw;
            }
            .data-table {
                font-size: 12px;
                min-width: 320px;
            }
            .header-tabs {
                font-size: 18px;
                padding: 8px 4px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header Tabs -->
        <div class="header-tabs">
            注文書一覧
        </div>
        <div class="content-area">
            <!-- Search Section -->
            <div class="search-section">
                <input type="text" class="search-input" placeholder="検索キーワード">
                <button class="search-btn">検索</button>
            </div>
            <!-- Data Table -->
            <div class="table-container">
                <div class="scroll-table">
                    <table class="data-table">
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
                        <tbody id="orderTable">
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
                                        <button type="submit" class="btn delete-btn" title="削除" onclick="return confirm('本当に削除しますか？');">&#10005;</button>
                                    <?= $this->Form->end() ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="button-section">
                <?= $this->Html->link('戻る',['controller' => 'List', 'action' => 'index'], ['class' => 'button']) ?>
            </div>
        </div>
        <button class="button" id="detailBtn" type="button">詳細</button>
    </div>
    <script>
        // 行選択
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#orderTable tr');
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
                    window.location.href = '/order-list/order-detail/' + orderId;
                } else {
                    alert('項目を選択してください');
                }
            });
        });
    </script>
</body>
</html>