
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>顧客一覧</title>
    <style>
        body {
            background: #f8f9fa;
            margin: 0;
            padding: 0;;
            font-family: 'MS UI Gothic', Arial, sans-serif;
            overflow-x: hidden;
        }
        .container {
            width: 100vw;
            margin: 0;
            padding: 40px 0 32px 0;
            background: #fff;
            border-radius: 0;
            box-shadow: none;
            box-sizing: border-box;
        }
        .button-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
        }
        .action-button {
            background-color: #1976d2;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0 40px;
            font-size: 20px;
            height: 44px;
            display: inline-block;
            text-align: center;
            line-height: 44px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        .action-button:hover {
            background: #1565c0;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
            background: #fff;
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 12px 8px;
            text-align: left;
            font-size: 18px;
        }
        th {
            background: #f5f5f5;
            font-weight: bold;
        }
        tr:hover {
            background: #f1f8ff;
        }
        .select-link {
            color: #1976d2;
            text-decoration: underline;
            cursor: pointer;
        }
        .back-button {
            display: block;
            width: 120px;
            height: 44px;
            margin: 0 auto;
            background: #e53935;
            color: #fff;
            border: none;
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

    <?= $this->element('header', ['title' => '顧客一覧']) ?>
    <div class="container" style="border:2px solid #222;">
        <div class="title">顧客選択</div>
        <form class="search-form" method="get">
            <input type="text" name="keyword" class="search-input" placeholder="顧客名で検索" value="<?= h($this->request->getQuery('keyword') ?? '') ?>">
            <button type="submit" class="search-button">検索</button>
        </form>
        <table>
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
                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $customer): ?>

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