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
            background-color: #f0f0f0;
        }
        .main-container {
            width: 1000px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f0f0f0;
        }
        .header-tabs {
            display: flex;
            border-bottom: 1px solid #808080;
            background: #1976d2;
            color: #fff;
            border-radius: 0;
            padding: 8px 16px;
        }
        .tab {
            padding: 6px 12px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        .tab:first-child {
            font-weight: bold;
        }
        .tab:last-child {
            flex: 1;
            font-size: 11px;
            opacity: 0.8;
        }
        .content-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 16px;
            background-color: #f0f0f0;
        }
        .search-section {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            gap: 8px;
        }
        .search-input {
            border: 1px solid #808080;
            padding: 2px 6px;
            font-size: 13px;
            height: 22px;
            width: 160px;
            background-color: white;
            border-radius: 4px;
        }
        .search-btn {
            background-color: #1976d2;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 2px 14px;
            font-size: 13px;
            height: 26px;
            cursor: pointer;
        }
        .search-btn:active {
            background: #1565c0;
        }
        .table-container {
            flex: 1;
            background-color: white;
            border: 1px solid #808080;
            border-radius: 6px;
            margin-bottom: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .scroll-table {
            flex: 1;
            overflow-y: auto;
            overflow-x: auto;
            max-height: 60vh; /* 表の高さを画面の60%までに制限 */
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            min-width: 600px;
        }
        .data-table th, .data-table td {
            border: 1px solid #e0e0e0;
            padding: 6px 10px;
            text-align: left;
            white-space: nowrap;
        }
        .data-table th {
            background: #e3f2fd;
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
            gap: 10px;
            margin-top: 8px;
        }
        .btn, .button {
            background-color: #1976d2;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 6px 24px;
            font-size: 13px;
            cursor: pointer;
            height: 32px;
        }
        .btn:active, .button:active {
            background: #1565c0;
        }
        @media screen and (max-width: 900px) {
            .data-table {
                font-size: 11px;
                min-width: 400px;
            }
            .content-area {
                padding: 4px;
            }
        }
        @media screen and (max-width: 600px) {
            .main-container {
                width: 100vw;
            }
            .data-table {
                font-size: 10px;
                min-width: 320px;
            }
            .header-tabs {
                font-size: 11px;
                padding: 6px 4px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header Tabs -->
        <div class="header-tabs">
            <div class="tab">MBS</div>
            <div class="tab">注文書一覧</div>
            <div class="tab">ホーム＞一覧確認＞注文書一覧</div>
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
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Action Buttons -->
            <div class="button-section">
                <?= $this->Html->link('戻る',['controller' => 'List', 'action' => 'index'], ['class' => 'button']) ?>
                <button class="btn" id="detailBtn" type="button">詳細</button>
            </div>
        </div>
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
                    window.location.href = '/list/order-detail/' + orderId;
                } else {
                    alert('項目を選択してください');
                }
            });
        });
    </script>
</body>
</html>