<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>MBS - 顧客一覧</title>
    <style>
        body {
            font-family: 'MS UI Gothic', Arial, sans-serif;
            font-size: 13px;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #e8e8e8;
            border: 2px inset #c0c0c0;
            width: 90vw;
            max-width: 1200px;
            margin: 30px auto;
            padding: 0;
            min-height: 80vh;
            box-sizing: border-box;
        }
        .header {
            background: linear-gradient(to bottom, #d4d4d4, #b8b8b8);
            border-bottom: 1px solid #999;
            display: flex;
            height: 32px;
            line-height: 32px;
        }
        .header-cell {
            border-right: 1px solid #999;
            padding: 0 16px;
            font-weight: bold;
            font-size: 14px;
        }
        .header-cell:last-child {
            border-right: none;
        }
        .content {
            padding: 24px;
            background-color: #fffbe6;
            min-height: 70vh;
        }
        .filter-section {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .filter-label {
            font-weight: bold;
            margin-right: 8px;
        }
        .dropdown-container {
            position: relative;
            display: inline-block;
        }
        .dropdown-display {
            width: 280px;
            height: 32px;
            border: 1px solid #999;
            background: white;
            display: flex;
            align-items: center;
            padding: 0 12px;
            cursor: pointer;
            font-size: 13px;
            position: relative;
        }
        .dropdown-display::after {
            content: "▼";
            position: absolute;
            right: 8px;
            font-size: 10px;
            color: #666;
        }
        .dropdown-display.active::after {
            content: "▲";
        }
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #999;
            border-top: none;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        .dropdown-menu.show {
            display: block;
        }
        .dropdown-item {
            padding: 8px 12px;
            cursor: pointer;
            font-size: 13px;
            border-bottom: 1px solid #eee;
        }
        .dropdown-item:hover {
            background-color: #e6f3ff;
        }
        .dropdown-item.selected {
            background-color: #316ac5;
            color: white;
        }
        .table-container {
            border: 1px solid #c0c0c0;
            background-color: white;
            height: 55vh;
            overflow-y: auto;
            margin-bottom: 24px;
        }
        table.customer-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        table.customer-table th, table.customer-table td {
            border: 1px solid #e0e0e0;
            padding: 8px 6px;
            text-align: left;
        }
        table.customer-table th {
            background: linear-gradient(to bottom, #f0f0f0, #d0d0d0);
            font-weight: bold;
        }
        table.customer-table tr.selected {
            background-color: #316ac5;
            color: white;
        }
        table.customer-table tr:hover {
            background-color: #e6f3ff;
        }
        .button-section {
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
        }
        .action-button {
            width: 110px;
            height: 36px;
            background: linear-gradient(to bottom, #f0f0f0, #d0d0d0);
            border: 1px solid #c0c0c0;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .action-button:active {
            border: 1px inset #c0c0c0;
        }
        .no-data-message {
            text-align: center;
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-cell">MBS</div>
            <div class="header-cell">顧客一覧</div>
            <div class="header-cell">ホーム＞顧客一覧</div>
        </div>
        <div class="content">
            <!-- 書店名選択ドロップダウン -->
            <div class="filter-section">
                <span class="filter-label">店舗名で絞り込み：</span>
                <div class="dropdown-container">
                    <div class="dropdown-display" id="dropdownDisplay">
                        <?= !empty($selectedBookstore) ? h($selectedBookstore) : '全ての店舗' ?>
                    </div>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <div class="dropdown-item <?= empty($selectedBookstore) ? 'selected' : '' ?>" 
                             onclick="selectBookstore('', '全ての店舗')">
                            全ての店舗
                        </div>
                        <?php if (!empty($bookstores)): ?>
                            <?php foreach ($bookstores as $bookstore): ?>
                                <div class="dropdown-item <?= ($selectedBookstore === $bookstore->bookstore_name) ? 'selected' : '' ?>" 
                                     onclick="selectBookstore('<?= h($bookstore->bookstore_name) ?>', '<?= h($bookstore->bookstore_name) ?>')">
                                    <?= h($bookstore->bookstore_name) ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <table class="customer-table">
                    <thead>
                        <tr>
                            <th>顧客ID</th>
                            <th>店舗名</th>
                            <th>顧客名</th>
                            <th>担当者名</th>
                            <th>電話番号</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($customers)): ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?= h($customer->customer_id) ?></td>
                                    <td><?= h($customer->bookstore_name) ?></td>
                                    <td><?= h($customer->name) ?></td>
                                    <td><?= h($customer->contact_person) ?></td>
                                    <td><?= h($customer->phone_number) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="no-data-message">
                                    <?= empty($selectedBookstore) ? '顧客データがありません' : '選択した書店の顧客データがありません' ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="button-section">
                <?= $this->Html->link('戻る', ['controller' => 'List', 'action' => 'index'], ['class' => 'action-button']) ?>
                <?= $this->Html->link('顧客登録', ['controller' => 'Customers', 'action' => 'add'], ['class' => 'action-button']) ?>
            </div>
        </div>
    </div>

    <script>
        // ドロップダウンの表示/非表示切り替え
        document.getElementById('dropdownDisplay').addEventListener('click', function() {
            const menu = document.getElementById('dropdownMenu');
            const display = document.getElementById('dropdownDisplay');
            
            if (menu.classList.contains('show')) {
                menu.classList.remove('show');
                display.classList.remove('active');
            } else {
                menu.classList.add('show');
                display.classList.add('active');
            }
        });

        // 書店選択時の処理
        function selectBookstore(bookstoreValue, displayText) {
            // 表示を更新
            document.getElementById('dropdownDisplay').textContent = displayText;
            
            // ドロップダウンを閉じる
            document.getElementById('dropdownMenu').classList.remove('show');
            document.getElementById('dropdownDisplay').classList.remove('active');
            
            // ページ遷移
            if (bookstoreValue === '') {
                window.location.href = '<?= $this->Url->build(['controller' => 'List', 'action' => 'customer']) ?>';
            } else {
                window.location.href = '<?= $this->Url->build(['controller' => 'List', 'action' => 'customer']) ?>?bookstore=' + encodeURIComponent(bookstoreValue);
            }
        }

        // 外部クリックでドロップダウンを閉じる
        document.addEventListener('click', function(event) {
            const container = document.querySelector('.dropdown-container');
            if (!container.contains(event.target)) {
                document.getElementById('dropdownMenu').classList.remove('show');
                document.getElementById('dropdownDisplay').classList.remove('active');
            }
        });
    </script>
</body>
</html>