<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>納品書一覧</title>
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
            overflow: hidden;
        }

        .main-content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        h1 {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
            flex-shrink: 0;
        }

        .success-message {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            flex-shrink: 0;
        }

        .create-section {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 18px;
            flex-shrink: 0;
        }

        .create-btn {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 0 24px;
            font-size: 16px;
            height: 36px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .create-btn:hover {
            background: #0056b3;
        }

        .search-section {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 24px;
            gap: 12px;
            flex-shrink: 0;
        }

        .search-input {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            border: 2px solid #ddd;
            padding: 0 12px;
            font-size: 16px;
            height: 36px;
            width: 400px;
            border-radius: 4px;
            background-color: white;
        }

        .search-btn {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 0 20px;
            font-size: 16px;
            height: 36px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }

        .search-btn:hover {
            background: #1e7e34;
        }

        .table-container {
            background-color: white;
            border-radius: 8px;
            margin-bottom: 20px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            border: 1px solid #e0e0e0;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0;
        }

        .scroll-table {
            overflow-y: auto;
            overflow-x: auto;
            flex: 1;
        }

        .data-table {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            min-width: 900px;
            background: #fff;
        }

        .data-table th, .data-table td {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            border: 1px solid #e0e0e0;
            padding: 12px 8px;
            text-align: left;
            white-space: nowrap;
        }

        .data-table th {
            background: #f5f5f5;
            font-weight: bold;
            position: sticky;
            top: 0;
            z-index: 2;
            text-align: center;
            font-size: 16px;
        }

        .data-table td {
            text-align: center;
        }

        .data-table td:first-child {
            color: #007bff;
            text-decoration: underline;
            cursor: pointer;
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
            background: #f8f9fa;
        }

        .delete-btn {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background: #dc3545;
            font-size: 14px;
            padding: 4px 8px;
            border-radius: 4px;
            border: none;
            color: #fff;
            cursor: pointer;
            transition: background 0.2s;
        }

        .delete-btn:hover {
            background: #c82333;
        }

        .button-section {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            margin-top: 20px;
            flex-shrink: 0;
            padding-top: 10px;
            border-top: 1px solid #e9ecef;
        }

        .button {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 0 30px;
            font-size: 16px;
            cursor: pointer;
            height: 40px;
            font-weight: bold;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .button:hover {
            background: #5a6268;
        }

        .button.detail-btn {
            background: #007bff;
        }

        .button.detail-btn:hover {
            background: #0056b3;
        }

        .no-data {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            text-align: center;
            color: #6c757d;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 4px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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
            flex-shrink: 0;
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

        /* レスポンシブ対応 */
        @media screen and (max-width: 768px) {
            .main-content {
                padding: 15px;
            }

            .search-input {
                width: 300px;
            }

            .button-section {
                flex-direction: column;
                gap: 10px;
            }

            .data-table {
                font-size: 14px;
            }

            .data-table th, .data-table td {
                padding: 8px 6px;
            }
        }

        @media screen and (max-width: 600px) {
            .data-table {
                font-size: 12px;
                min-width: 320px;
            }
            h1 {
                font-size: 20px;
            }
            .main-content {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <?= $this->element('common_header') ?>

    <div class="main-content">
        <h1>納品書一覧</h1>

        <!-- Flash メッセージ表示 -->
        <?= $this->Flash->render() ?>

        <!-- 新規作成ボタン -->
        <div class="create-section">
            <?= $this->Html->link('新規作成', ['controller' => 'RegDeliveries', 'action' => 'select_customer'], ['class' => 'create-btn']) ?>
        </div>

        <!-- 検索セクション -->
        <div class="search-section">
            <form method="get" style="display: flex; gap: 12px;">
                <input type="text" name="keyword" class="search-input" placeholder="検索キーワード" value="<?= h($keyword ?? '') ?>">
                <button type="submit" class="search-btn">検索</button>
            </form>
        </div>

        <!-- データテーブル -->
        <?php if (!empty($deliveries)): ?>
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
                <p>納品書データが見つかりませんでした。</p>
            </div>
        <?php endif; ?>

        <!-- ボタンセクション -->
        <div class="button-section">
            <?= $this->Html->link('戻る', ['controller' => 'Home', 'action' => 'index'], ['class' => 'button']) ?>
            <button class="button detail-btn" id="detailBtn" type="button">詳細</button>
        </div>
    </div>

    <script>
        // 行選択とナビゲーション
        document.addEventListener('DOMContentLoaded', function() {
            const deliveryDetailBaseUrl = <?= json_encode(rtrim($this->Url->build(["controller" => "List", "action" => "delivery_detail"]), '/')) ?>;
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
                    window.location.href = deliveryDetailBaseUrl + '/' + encodeURIComponent(deliveryId);
                } else {
                    alert('項目を選択してください');
                }
            });
        });
    </script>
</body>
</html>