<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>MBS - 顧客一覧</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Hiragino Kaku Gothic ProN', 'Yu Gothic', 'Meiryo', sans-serif;
            font-size: 14px;
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        /* メインコンテンツ */
        .main-content {
            padding: 20px;
            background: white;
            min-height: calc(100vh - 60px);
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .page-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
        }
        
        .add-button {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            font-weight: normal;
            transition: background-color 0.2s;
        }
        
        .add-button:hover {
            background: #0056b3;
        }
        
        /* フィルターセクション */
        .filter-section {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .filter-label {
            font-weight: 600;
            color: #333;
            white-space: nowrap;
        }
        
        /* カスタムドロップダウン */
        .custom-dropdown {
            position: relative;
            display: inline-block;
            min-width: 250px;
        }
        
        .dropdown-display {
            padding: 8px 40px 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            background: white;
            cursor: pointer;
            transition: border-color 0.2s;
        }
        
        .dropdown-display:hover {
            border-color: #007bff;
        }
        
        .dropdown-display.active {
            border-color: #007bff;
        }
        
        /* カスタム矢印 */
        .dropdown-arrow {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            font-size: 14px;
            color: #666;
            transition: transform 0.2s ease;
        }
        
        .dropdown-display.active + .dropdown-arrow {
            transform: translateY(-50%) rotate(180deg);
        }
        
        /* ドロップダウンメニュー */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 4px 4px;
            max-height: 200px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
        }
        
        .dropdown-menu.show {
            display: block;
        }
        
        .dropdown-item {
            padding: 10px 12px;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        
        .dropdown-item.active {
            background-color: #007bff;
            color: white;
        }
        
        /* テーブルコンテナ - スクロール対応 */
        .table-wrapper {
            border: 1px solid #ddd;
            border-radius: 4px;
            overflow: hidden;
            background: white;
            margin-bottom: 20px;
            position: relative;
        }
        
        .scrollable-table {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: auto;
        }
        
        .customer-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            background: white;
        }
        
        .customer-table th {
            background: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .customer-table td {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }
        
        .customer-table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        .customer-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .no-data-message {
            text-align: center;
            padding: 40px;
            color: #6c757d;
            font-style: italic;
        }
        
        /* 戻るボタン */
        .button {
            background: #6c757d;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            font-weight: normal;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-top: 20px;
        }
        
        .back-button:hover {
            background: #5a6268;
        }
        
        .back-button::before {
            content: "←";
            font-size: 16px;
        }
        
        /* ボタンセクション */
        .button-section {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }
        
        /* テーブルの行の調整 */
        .customer-table th:first-child,
        .customer-table td:first-child {
            width: 80px;
        }
        
        .customer-table th:nth-child(2),
        .customer-table td:nth-child(2) {
            width: 150px;
        }
        
        .customer-table th:nth-child(3),
        .customer-table td:nth-child(3) {
            width: 200px;
        }
        
        .customer-table th:nth-child(4),
        .customer-table td:nth-child(4) {
            width: 150px;
        }
        
        .customer-table th:nth-child(5),
        .customer-table td:nth-child(5) {
            width: 150px;
        }
        
        /* スクロールバーのスタイリング */
        .scrollable-table::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        .scrollable-table::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        
        .scrollable-table::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }
        
        .scrollable-table::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* 縦横スクロールバーの角 */
        .scrollable-table::-webkit-scrollbar-corner {
            background: #f1f1f1;
        }
        
        /* スクロールインジケーター */
        .scroll-indicator {
            position: absolute;
            bottom: 10px;
            right: 20px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            display: none;
            z-index: 5;
        }
        
        .table-wrapper:hover .scroll-indicator {
            display: block;
        }
    </style>
</head>
<body>
    <!-- 共通ヘッダーを読み込み -->
    <?= $this->element('common_header') ?>

    <!-- メインコンテンツ -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">顧客一覧</h1>
            <?= $this->Html->link('新規作成', ['controller' => 'Customers', 'action' => 'add'], ['class' => 'add-button']) ?>
        </div>

        <!-- フィルターセクション -->
        <div class="filter-section">
            <label class="filter-label">店舗名で絞り込み</label>
            <div class="custom-dropdown">
                <div class="dropdown-display" id="dropdownDisplay">全ての店舗</div>
                <span class="dropdown-arrow">▼</span>
                <div class="dropdown-menu" id="dropdownMenu">
                    <div class="dropdown-item active" data-value="">全ての店舗</div>
                    <?php if (!empty($bookstores)): ?>
                        <?php foreach ($bookstores as $bookstore): ?>
                            <div class="dropdown-item" data-value="<?= h($bookstore->bookstore_name) ?>">
                                <?= h($bookstore->bookstore_name) ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- テーブル（スクロール対応） -->
        <div class="table-wrapper">
            <div class="scrollable-table">
                <table class="customer-table">
                    <thead>
                        <tr>
                            <th>顧客ID</th>
                            <th>店舗名</th>
                            <th>顧客名</th>
                            <th>電話番号</th>
                            <th>担当者名</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($customers)): ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?= h($customer->customer_id) ?></td>
                                    <td><?= h($customer->bookstore_name) ?></td>
                                    <td><?= h($customer->name) ?></td>
                                    <td><?= h($customer->phone_number) ?></td>
                                    <td><?= h($customer->contact_person ?? '未設定') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="no-data-message">
                                    <?= empty($selectedBookstore) ? '顧客データがありません' : '選択した店舗の顧客データがありません' ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ボタンセクション -->
        <div class="button-section">
            <?= $this->Html->link('戻る', ['controller' => 'Home', 'action' => 'index'], ['class' => 'button']) ?>
        </div>
    </main>

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

        // ドロップダウンアイテムクリックイベント
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownItems = document.querySelectorAll('.dropdown-item');
            
            dropdownItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const text = this.textContent;
                    
                    // アクティブ状態を更新
                    dropdownItems.forEach(function(i) {
                        i.classList.remove('active');
                    });
                    this.classList.add('active');
                    
                    selectBookstore(value, text);
                });
            });
            
            // 外部クリックでドロップダウンを閉じる
            document.addEventListener('click', function(event) {
                const dropdown = document.querySelector('.custom-dropdown');
                if (!dropdown.contains(event.target)) {
                    document.getElementById('dropdownMenu').classList.remove('show');
                    document.getElementById('dropdownDisplay').classList.remove('active');
                }
            });
        });

        // スクロール状態の監視
        document.addEventListener('DOMContentLoaded', function() {
            const scrollableTable = document.querySelector('.scrollable-table');
            const scrollIndicator = document.querySelector('.scroll-indicator');

            if (scrollableTable && scrollIndicator) {
                scrollableTable.addEventListener('scroll', function() {
                    const scrollTop = this.scrollTop;
                    const scrollHeight = this.scrollHeight;
                    const clientHeight = this.clientHeight;
                    
                    // スクロール可能な場合のみインジケーターを表示
                    if (scrollHeight > clientHeight) {
                        scrollIndicator.style.display = 'block';
                        
                        // 下端近くになったらインジケーターを隠す
                        if (scrollTop + clientHeight >= scrollHeight - 10) {
                            scrollIndicator.style.display = 'none';
                        }
                    } else {
                        scrollIndicator.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>