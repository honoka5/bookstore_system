<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>顧客選択</title>
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
            height: calc(100vh - 60px);
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
            min-width: 700px;
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

        .data-table tr.selectable-row {
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .data-table tr.selectable-row:hover td {
            background: #f8f9fa;
        }

        .data-table tr.selected {
            background: #1976d2 !important;
            color: #fff;
        }

        .data-table tr.selected td {
            background: #1976d2 !important;
            color: #fff;
        }

        .select-btn {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 4px 12px;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .select-btn:hover {
            background: #0056b3;
        }

        .pagination-section {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 15px 0;
            gap: 15px;
            flex-shrink: 0;
        }

        .pagination-section a {
            color: #007bff;
            text-decoration: none;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: all 0.2s;
        }

        .pagination-section a:hover {
            background: #007bff;
            color: white;
        }

        .pagination-section span {
            font-weight: bold;
            color: #333;
        }

        .button-section {
            display: flex;
            justify-content: flex-start;
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

        .no-data {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            text-align: center;
            color: #dc3545;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 4px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-size: 16px;
        }

        .no-data p {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            font-weight: bold;
        }

        /* レスポンシブ対応 */
        @media screen and (max-width: 768px) {
            .main-content {
                padding: 15px;
                height: calc(100vh - 50px);
            }

            .search-input {
                width: 300px;
            }

            .data-table {
                font-size: 14px;
            }

            .data-table th, .data-table td {
                padding: 8px 6px;
            }

            h1 {
                font-size: 20px;
                margin-bottom: 15px;
            }
        }

        @media screen and (max-width: 600px) {
            .main-content {
                padding: 10px;
                height: calc(100vh - 45px);
            }

            .data-table {
                font-size: 12px;
                min-width: 320px;
            }

            .data-table th, .data-table td {
                padding: 6px 4px;
            }

            h1 {
                font-size: 18px;
                margin-bottom: 12px;
            }

            .button {
                height: 36px;
                font-size: 14px;
                padding: 0 20px;
            }
        }
    </style>
</head>
<body>
    <?= $this->element('common_header') ?>

    <div class="main-content">
        <h1>顧客選択</h1>

        <!-- 検索セクション -->
        <div class="search-section">
            <form method="get" onsubmit="return checkKeyword();" style="display: flex; gap: 12px;">
                <input type="text" name="keyword" id="keyword" class="search-input" placeholder="顧客名で検索" value="<?= h($keyword ?? '') ?>">
                <button type="submit" class="search-btn">検索</button>
            </form>
        </div>

        <?php
        // 検索ボタンを押さなくてもリストが表示されるように修正
        if (empty($keyword)) {
            // 検索キーワードが空の場合も全件ページング表示
            $showList = true;
        } else {
            $showList = true;
        }
        ?>

        <?php if ($showList): ?>
            <?php if (empty($customers) || count($customers->toArray()) === 0): ?>
                <div class="no-data">
                    <p>顧客が見つかりませんでした</p>
                </div>
            <?php else: ?>
                <!-- データテーブル -->
                <div class="table-container">
                    <div class="scroll-table">
                        <table class="data-table" id="customer-table">
                            <thead>
                                <tr>
                                    <th>顧客ID</th>
                                    <th>顧客名</th>
                                    <th>電話番号</th>
                                    <th>担当者名</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $customer): ?>
                                <tr class="selectable-row" data-href="<?= $this->Url->build(['action' => 'newOrder', $customer->customer_id]) ?>">
                                    <td><?= h($customer->customer_id) ?></td>
                                    <td><?= h($customer->name) ?></td>
                                    <td><?= h($customer->phone_number) ?></td>
                                    <td><?= h($customer->contact_person) ?></td>
                                    <td>
                                        <?= $this->Html->link('選択', ['action' => 'newOrder', $customer->customer_id], ['class' => 'select-btn']) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ページング -->
                <?php
                // ページング矢印
                $totalPages = ceil($total / $limit);
                $baseUrl = $this->Url->build([
                    'action' => 'selectCustomer',
                ]);
                $queryParams = $_GET;
                unset($queryParams['page']);
                $queryStr = http_build_query($queryParams);
                ?>
                <?php if ($totalPages > 1): ?>
                <div class="pagination-section">
                    <?php if ($page > 1): ?>
                        <a href="<?= $baseUrl . ($queryStr ? ('?' . $queryStr . '&') : '?') . 'page=' . ($page - 1) ?>">&lt; 前へ</a>
                    <?php endif; ?>
                    <span><?= $page ?> / <?= $totalPages ?></span>
                    <?php if ($page < $totalPages): ?>
                        <a href="<?= $baseUrl . ($queryStr ? ('?' . $queryStr . '&') : '?') . 'page=' . ($page + 1) ?>">次へ &gt;</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>

        <!-- ボタンセクション -->
        <div class="button-section">
            <?= $this->Html->link('戻る', ['controller' => 'List', 'action' => 'order'], ['class' => 'button']) ?>
        </div>
    </div>

    <script>
        // 顧客テーブルの行クリックで遷移（aタグ以外）
        document.addEventListener('DOMContentLoaded', function() {
            var rows = document.querySelectorAll('#customer-table .selectable-row');
            rows.forEach(function(row) {
                row.style.cursor = 'pointer';
                row.addEventListener('click', function(e) {
                    // ボタン押下時は二重遷移防止
                    if (e.target.tagName.toLowerCase() === 'a') return;
                    window.location = row.getAttribute('data-href');
                });
            });
        });

        function checkKeyword() {
            var kw = document.getElementById('keyword').value.trim();
            if (kw === '') {
                alert('顧客名を入力してください');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>