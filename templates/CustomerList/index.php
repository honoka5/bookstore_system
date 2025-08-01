<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            height: 100vh;
            overflow: hidden; /* デスクトップでは外側のスクロールを無効化 */
        }
        
        /* メインコンテンツ */
        .main-content {
            padding: 15px;
            background: white;
            height: calc(100vh - 60px);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
            flex-shrink: 0; /* 高さを固定 */
        }
        
        .page-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        
        .add-button {
            background: #007bff;
            color: white;
            padding: 8px 16px;
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
            margin-bottom: 15px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 4px;
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0; /* 高さを固定 */
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
            position: relative;
            flex: 1; /* 残りの高さを全て使用 */
            min-height: 0; /* flexの制約を適用 */
        }
        
        .scrollable-table {
            height: 100%; /* 親の高さを100%使用 */
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
            padding: 10px;
            text-align: left;
            font-weight: 600;
            color: #495057;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        .customer-table td {
            padding: 10px;
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
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            font-weight: normal;
            transition: background-color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .button:hover {
            background: #5a6268;
        }
        
        /* ボタンセクション */
        .button-section {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #e9ecef;
            flex-shrink: 0; /* 高さを固定 */
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

        /* タブレット対応 (769px - 1024px) */
        @media (max-width: 1024px) and (min-width: 769px) {
            body {
                overflow: hidden; /* タブレットでもスクロール無効 */
            }
            
            .main-content {
                overflow: hidden;
            }
            
            .page-title {
                font-size: 22px;
            }
            
            .custom-dropdown {
                min-width: 200px;
            }
        }

        /* スマホ対応 (768px以下) */
        @media (max-width: 768px) {
            body {
                overflow-y: auto; /* スマホでは縦スクロール有効 */
                overflow-x: hidden; /* 横スクロールは無効 */
                height: auto; /* 高さ制限を解除 */
                min-height: 100vh; /* 最小高さは確保 */
            }
            
            .main-content {
                height: auto; /* 高さ制限を解除 */
                min-height: calc(100vh - 50px); /* 最小高さは確保 */
                overflow: visible; /* スクロール有効 */
                padding: 12px;
            }
            
            .page-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                text-align: center;
                margin-bottom: 15px;
            }
            
            .page-title {
                font-size: 20px;
                margin-bottom: 8px;
            }
            
            .add-button {
                align-self: center;
                padding: 10px 20px;
                font-size: 15px;
            }
            
            .filter-section {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
                padding: 10px;
                margin-bottom: 12px;
            }
            
            .filter-label {
                text-align: center;
                font-size: 14px;
            }
            
            .custom-dropdown {
                min-width: 100%;
                width: 100%;
            }
            
            .dropdown-display {
                padding: 10px 40px 10px 12px;
                font-size: 15px;
            }
            
            .dropdown-menu {
                max-height: 150px;
            }
            
            .dropdown-item {
                padding: 12px 15px;
                font-size: 15px;
            }
            
            .table-wrapper {
                border-radius: 6px;
                margin-bottom: 15px;
            }
            
            .customer-table {
                font-size: 12px;
                min-width: 500px; /* 横スクロール対応 */
            }
            
            .customer-table th,
            .customer-table td {
                padding: 8px 6px;
                white-space: nowrap;
            }
            
            .customer-table th {
                font-size: 11px;
                font-weight: 700;
            }
            
            /* スマホでのテーブル列幅調整 */
            .customer-table th:first-child,
            .customer-table td:first-child {
                width: 60px;
            }
            
            .customer-table th:nth-child(2),
            .customer-table td:nth-child(2) {
                width: 120px;
            }
            
            .customer-table th:nth-child(3),
            .customer-table td:nth-child(3) {
                width: 140px;
            }
            
            .customer-table th:nth-child(4),
            .customer-table td:nth-child(4) {
                width: 120px;
            }
            
            .customer-table th:nth-child(5),
            .customer-table td:nth-child(5) {
                width: 120px;
            }
            
            .button-section {
                margin-top: 12px;
                padding-top: 8px;
                text-align: center;
            }
            
            .button {
                padding: 10px 20px;
                font-size: 15px;
            }
            
            .no-data-message {
                padding: 30px 15px;
                font-size: 14px;
            }
        }

        /* 小型スマホ対応 (480px以下) */
        @media (max-width: 480px) {
            .main-content {
                padding: 8px;
            }
            
            .page-title {
                font-size: 18px;
            }
            
            .add-button {
                padding: 8px 16px;
                font-size: 14px;
            }
            
            .filter-section {
                padding: 8px;
            }
            
            .filter-label {
                font-size: 13px;
            }
            
            .dropdown-display {
                padding: 8px 35px 8px 10px;
                font-size: 14px;
            }
            
            .dropdown-item {
                padding: 10px 12px;
                font-size: 14px;
            }
            
            .customer-table {
                font-size: 11px;
                min-width: 450px;
            }
            
            .customer-table th,
            .customer-table td {
                padding: 6px 4px;
            }
            
            .customer-table th {
                font-size: 10px;
            }
            
            /* 小型スマホでのテーブル列幅調整 */
            .customer-table th:first-child,
            .customer-table td:first-child {
                width: 50px;
            }
            
            .customer-table th:nth-child(2),
            .customer-table td:nth-child(2) {
                width: 100px;
            }
            
            .customer-table th:nth-child(3),
            .customer-table td:nth-child(3) {
                width: 120px;
            }
            
            .customer-table th:nth-child(4),
            .customer-table td:nth-child(4) {
                width: 100px;
            }
            
            .customer-table th:nth-child(5),
            .customer-table td:nth-child(5) {
                width: 100px;
            }
            
            .button {
                padding: 8px 16px;
                font-size: 14px;
            }
            
            .no-data-message {
                padding: 20px 10px;
                font-size: 13px;
            }
        }
        
        /* 非常に小さい画面対応 (360px以下) */
        @media (max-width: 360px) {
            .main-content {
                padding: 6px;
            }
            
            .page-title {
                font-size: 16px;
            }
            
            .customer-table {
                font-size: 10px;
                min-width: 320px;
            }
            
            .customer-table th,
            .customer-table td {
                padding: 4px 3px;
            }
            
            .customer-table th {
                font-size: 9px;
            }
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
            <?= $this->Html->link('顧客登録', ['controller' => 'Customers', 'action' => 'add'], ['class' => 'add-button']) ?>
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
            // ページ読み込み時に選択済み店舗を表示
            const currentBookstore = '<?= h($selectedBookstore ?? '') ?>';
            if (currentBookstore) {
                document.getElementById('dropdownDisplay').textContent = currentBookstore;
                // アクティブ状態を設定
                const activeItem = document.querySelector(`[data-value="${currentBookstore}"]`);
                if (activeItem) {
                    // 他のアクティブ状態をリセット
                    document.querySelectorAll('.dropdown-item').forEach(item => {
                        item.classList.remove('active');
                    });
                    activeItem.classList.add('active');
                }
            }
            
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
    </script>
</body>
</html>