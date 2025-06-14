<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBS - 顧客一覧</title>
    <style>
        body {
            font-family: 'MS UI Gothic', Arial, sans-serif;
            font-size: 12px;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        .container {
            background-color: #e8e8e8;
            border: 2px inset #c0c0c0;
            width: 500px;
            margin: 0 auto;
            padding: 0;
        }

        .header {
            background: linear-gradient(to bottom, #d4d4d4, #b8b8b8);
            border-bottom: 1px solid #999;
            display: flex;
            height: 25px;
            line-height: 25px;
        }

        .header-cell {
            border-right: 1px solid #999;
            padding: 0 8px;
            font-weight: bold;
            font-size: 11px;
        }

        .header-cell:first-child {
            width: 60px;
        }

        .header-cell:nth-child(2) {
            width: 80px;
        }

        .header-cell:last-child {
            flex: 1;
            border-right: none;
        }

        .content {
            padding: 15px;
            background-color: #e8e8e8;
        }

        .search-section {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .search-input {
            width: 120px;
            height: 20px;
            border: 1px inset #c0c0c0;
            padding: 2px 4px;
            font-size: 11px;
        }

        .search-button {
            width: 50px;
            height: 26px;
            background: linear-gradient(to bottom, #f0f0f0, #d0d0d0);
            border: 1px outset #c0c0c0;
            font-size: 11px;
            cursor: pointer;
        }

        .search-button:active {
            border: 1px inset #c0c0c0;
        }

        .table-container {
            border: 1px inset #c0c0c0;
            background-color: white;
            height: 120px;
            position: relative;
        }

        .table-header {
            background: linear-gradient(to bottom, #f0f0f0, #d0d0d0);
            border-bottom: 1px solid #999;
            display: flex;
            height: 20px;
            line-height: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .table-header div {
            border-right: 1px solid #999;
            padding: 0 5px;
        }

        .table-header div:first-child {
            width: 120px;
        }

        .table-header div:nth-child(2) {
            width: 120px;
        }

        .table-header div:last-child {
            flex: 1;
            border-right: none;
        }

        .table-body {
            height: 99px;
            overflow-y: auto;
            font-size: 11px;
        }

        .table-row {
            display: flex;
            height: 18px;
            line-height: 18px;
            cursor: pointer;
        }

        .table-row:hover {
            background-color: #e6f3ff;
        }

        .table-row.selected {
            background-color: #316ac5;
            color: white;
        }

        .table-row div {
            border-right: 1px solid #e0e0e0;
            padding: 0 5px;
            overflow: hidden;
            white-space: nowrap;
        }

        .table-row div:first-child {
            width: 120px;
        }

        .table-row div:nth-child(2) {
            width: 120px;
        }

        .table-row div:last-child {
            flex: 1;
            border-right: none;
        }

        .scrollbar {
            position: absolute;
            right: 0;
            top: 20px;
            width: 16px;
            height: 99px;
            background: #f0f0f0;
            border-left: 1px solid #999;
        }

        .scrollbar-track {
            width: 14px;
            height: 97px;
            margin: 1px;
            background: #e0e0e0;
            position: relative;
        }

        .scrollbar-thumb {
            width: 14px;
            height: 30px;
            background: linear-gradient(to right, #d0d0d0, #b0b0b0);
            border: 1px outset #c0c0c0;
            position: absolute;
            top: 0;
            cursor: pointer;
        }

        .scrollbar-button {
            width: 16px;
            height: 16px;
            background: linear-gradient(to bottom, #f0f0f0, #d0d0d0);
            border: 1px outset #c0c0c0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            cursor: pointer;
        }

        .scrollbar-up {
            position: absolute;
            right: 0;
            top: 20px;
        }

        .scrollbar-down {
            position: absolute;
            right: 0;
            bottom: 0;
        }

        .button-section {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
        }

        .action-button {
            width: 70px;
            height: 26px;
            background: linear-gradient(to bottom, #f0f0f0, #d0d0d0);
            border: 1px outset #c0c0c0;
            font-size: 11px;
            cursor: pointer;
        }

        .action-button:active {
            border: 1px inset #c0c0c0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-cell">MBS</div>
            <div class="header-cell">一覧確認</div>
            <div class="header-cell">ホーム＞顧客一覧</div>
        </div>
        
        <div class="content">
            <div class="search-section">
                <input type="text" class="search-input" placeholder="">
                <button class="search-button" onclick="searchCustomers()">検索</button>
            </div>
            
            <div class="table-container">
                <div class="table-header">
                    <div>顧客名</div>
                    <div>電話番号</div>
                    <div>担当者名</div>
                </div>
                
                <div class="table-body" id="tableBody">
                    <div class="table-row" onclick="selectRow(this)">
                        <div>大谷建設（株）</div>
                        <div>020-0101-0101</div>
                        <div>長尾淳</div>
                    </div>
                    <div class="table-row selected" onclick="selectRow(this)">
                        <div>大谷真美子</div>
                        <div>040-0404-0404</div>
                        <div></div>
                    </div>
                </div>
                
                <!-- カスタムスクロールバー -->
                <div class="scrollbar-up scrollbar-button">▲</div>
                <div class="scrollbar">
                    <div class="scrollbar-track">
                        <div class="scrollbar-thumb"></div>
                    </div>
                </div>
                <div class="scrollbar-down scrollbar-button">▼</div>
            </div>
            
            <div class="button-section">
                <button class="action-button" onclick="goBack()">戻る</button>
                <button class="action-button" onclick="registerCustomer()">顧客登録</button>
            </div>
        </div>
    </div>

    <script>
        // 行選択機能
        function selectRow(row) {
            // 既存の選択を解除
            const selectedRows = document.querySelectorAll('.table-row.selected');
            selectedRows.forEach(r => r.classList.remove('selected'));
            
            // 新しい行を選択
            row.classList.add('selected');
        }

        // 検索機能
        function searchCustomers() {
            const searchTerm = document.querySelector('.search-input').value;
            alert('検索機能: "' + searchTerm + '"');
        }

        // 戻るボタン
        function goBack() {
            alert('前の画面に戻ります');
        }

        // 顧客登録ボタン
        function registerCustomer() {
            alert('顧客登録画面を開きます');
        }

        // スクロールバー機能
        document.querySelector('.scrollbar-up').addEventListener('click', function() {
            const tableBody = document.getElementById('tableBody');
            tableBody.scrollTop -= 20;
        });

        document.querySelector('.scrollbar-down').addEventListener('click', function() {
            const tableBody = document.getElementById('tableBody');
            tableBody.scrollTop += 20;
        });

        // スクロールバーのドラッグ機能
        let isDragging = false;
        const thumb = document.querySelector('.scrollbar-thumb');
        const track = document.querySelector('.scrollbar-track');
        const tableBody = document.getElementById('tableBody');

        thumb.addEventListener('mousedown', function(e) {
            isDragging = true;
            e.preventDefault();
        });

        document.addEventListener('mousemove', function(e) {
            if (isDragging) {
                const trackRect = track.getBoundingClientRect();
                const mouseY = e.clientY - trackRect.top;
                const thumbPosition = Math.max(0, Math.min(mouseY - 15, track.offsetHeight - thumb.offsetHeight));
                
                thumb.style.top = thumbPosition + 'px';
                
                // テーブルのスクロール位置を更新
                const scrollRatio = thumbPosition / (track.offsetHeight - thumb.offsetHeight);
                tableBody.scrollTop = scrollRatio * (tableBody.scrollHeight - tableBody.offsetHeight);
            }
        });

        document.addEventListener('mouseup', function() {
            isDragging = false;
        });

        // テーブルスクロールに合わせてスクロールバーを更新
        tableBody.addEventListener('scroll', function() {
            const scrollRatio = tableBody.scrollTop / (tableBody.scrollHeight - tableBody.offsetHeight);
            const thumbPosition = scrollRatio * (track.offsetHeight - thumb.offsetHeight);
            thumb.style.top = thumbPosition + 'px';
        });
    </script>
</body>
</html>