<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>納品書一覧</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: "MS UI Gothic", sans-serif;
            background-color: #f0f0f0;
        }
        .main-container {
            max-width: 1200px;
            min-height: 100vh;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            background-color: #fff;
        }
        .header-bar {
            width: 100%;
            background: #1976d2;
            color: #fff;
            padding: 36px 0 24px 0;
            text-align: center;
            font-size: 48px;
            font-weight: bold;
            letter-spacing: 8px;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            margin-bottom: 32px;
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
            border-radius: 8px;
            padding: 0 32px;
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
            border-radius: 8px;
            margin-bottom: 24px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            border: 1px solid #e0e0e0;
        }
        .scroll-table {
            flex: 1;
            overflow-y: auto;
            overflow-x: auto;
            max-height: 60vh;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 20px;
            min-width: 900px;
            background: #fff;
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
        .delete-btn {
            background: #e53935;
            font-size: 20px;
            padding: 0 18px;
            height: 36px;
            border-radius: 8px;
            border: none;
            color: #fff;
            cursor: pointer;
            transition: background 0.2s;
        }
        .delete-btn:hover {
            background: #b71c1c;
        }
        .button-section {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 24px;
        }
        .button, .btn {
            background-color: #1976d2;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0 40px;
            font-size: 22px;
            cursor: pointer;
            height: 48px;
            font-weight: bold;
            transition: background 0.2s;
        }
        .button:active, .btn:active,
        .button:hover, .btn:hover {
            background: #1565c0;
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
            .header-bar {
                font-size: 28px;
                padding: 18px 0 12px 0;
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
            .header-bar {
                font-size: 16px;
                padding: 8px 0 6px 0;
            }
        }
    </style>
</head>
<body>
    <?= $this->element('header', ['title' => '納品書一覧']) ?>
    <div class="main-container" style="border:2px solid #222;">
        <div class="content-area">
            <!-- Search Section -->
            <div class="search-section">
                <input type="text" class="search-input" placeholder="検索キーワード">
                <button class="search-btn">検索</button>
            </div>
            <!-- Data Table -->
            <div class="table-container">
                <div class="scroll-table">
                    <table class="data-table" id="deliveryTable">
                        <thead>
                            <tr>
                                <th>納品書ID</th>
                                <th>顧客ID</th>
                                <th>顧客名</th>
                                <th>金額</th>
                                <th>納品日</th>
                                <th>備考</th>
                                <th>削除</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($deliveries ?? [] as $delivery): ?>
                        <?php if (!is_object($delivery)) continue; ?>
                        <tr>
                            <td><?= h($delivery->delivery_id) ?></td>
                            <td><?= h($delivery->customer_id) ?></td>
                            <td><?= h($delivery->customer->name ?? '') ?></td>
                            <td><?= h($delivery->total_amount ?? '') ?></td>
                            <td><?= h($delivery->delivery_date) ?></td>
                            <td><?= h($delivery->remark ?? '') ?></td>
                            <td>
                                <?= $this->Form->create(null, [
                                    'url' => ['controller'=>'DeliveryList','action'=>'deleteDelivery', h($delivery->delivery_id)],
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
                <?= $this->Html->link('戻る',['controller' => 'Home', 'action' => 'index'], ['class' => 'button']) ?>
                <button class="button" id="detailBtn" type="button">詳細</button>
            </div>
        </div>
        
    </div>
    <script>
        // 行選択
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#deliveryTable tbody tr');
            rows.forEach(row => {
                row.addEventListener('click', function() {
                    if (!this.cells[0].textContent.trim()) return;
                    rows.forEach(r => r.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
            // 詳細ボタン
            document.getElementById('detailBtn').addEventListener('click', function() {
                const selectedRow = document.querySelector('#deliveryTable tr.selected');
                if (selectedRow && selectedRow.cells[0].textContent.trim()) {
                    const deliveryId = selectedRow.cells[0].textContent.trim();
                     window.location.href = '/list/deliveryDetail/' + deliveryId;
                } else {
                    alert('項目を選択してください');
                }
            });
        });
    </script>
</body>
</html>