<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBS 管理システム</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "MS UI Gothic", sans-serif;
            font-size: 11px;
            background-color: #f0f0f0;
            padding: 10px;
        }

        .main-container {
            background-color: #f0f0f0;
            border: 2px solid #808080;
            border-top-color: #c0c0c0;
            border-left-color: #c0c0c0;
            width: 480px;
            margin: 0 auto;
        }

        /* Header Tabs */
        .header-tabs {
            display: flex;
            border-bottom: 1px solid #808080;
        }

        .tab {
            background-color: #f0f0f0;
            border-right: 1px solid #808080;
            padding: 4px 8px;
            font-size: 11px;
            height: 22px;
            display: flex;
            align-items: center;
        }

        .tab:first-child {
            width: 50px;
            justify-content: center;
            font-weight: bold;
        }

        .tab:nth-child(2) {
            width: 80px;
            justify-content: center;
        }

        .tab:last-child {
            flex: 1;
            padding-left: 12px;
        }

        /* Content Area */
        .content-area {
            padding: 8px;
            background-color: #f0f0f0;
        }

        /* Search Section */
        .search-section {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            gap: 6px;
        }

        .search-icon {
            width: 16px;
            height: 16px;
            background-color: #e0e0e0;
            border: 1px solid #808080;
            border-top-color: #c0c0c0;
            border-left-color: #c0c0c0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #666;
        }

        .search-btn {
            background-color: #e0e0e0;
            border: 1px solid #808080;
            border-top-color: #c0c0c0;
            border-left-color: #c0c0c0;
            padding: 2px 12px;
            font-size: 11px;
            height: 20px;
            cursor: pointer;
        }

        .search-btn:active {
            border-top-color: #808080;
            border-left-color: #808080;
            border-bottom-color: #c0c0c0;
            border-right-color: #c0c0c0;
        }

        /* Table Container */
        .table-container {
            border: 2px solid #808080;
            border-top-color: #404040;
            border-left-color: #404040;
            background-color: white;
            height: 140px;
            position: relative;
            margin-bottom: 8px;
        }

        .table-wrapper {
            height: 100%;
            overflow: hidden;
            padding-right: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        th {
            background-color: #e0e0e0;
            border: 1px solid #808080;
            border-top-color: #c0c0c0;
            border-left-color: #c0c0c0;
            padding: 2px 4px;
            text-align: left;
            font-weight: normal;
            height: 18px;
            font-size: 11px;
        }

        td {
            border-right: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            padding: 1px 4px;
            height: 16px;
            font-size: 11px;
            background-color: white;
        }

        /* Row Selection */
        .row-selected {
            background-color: #0066cc !important;
        }

        .row-selected td {
            background-color: #0066cc !important;
            color: white;
        }

        .row-normal:hover {
            background-color: #e6f3ff;
        }

        .row-normal:hover td {
            background-color: #e6f3ff;
        }

        /* Column Widths */
        th:nth-child(1), td:nth-child(1) { width: 60px; }
        th:nth-child(2), td:nth-child(2) { width: 50px; }
        th:nth-child(3), td:nth-child(3) { width: 120px; }
        th:nth-child(4), td:nth-child(4) { width: 60px; }
        th:nth-child(5), td:nth-child(5) { width: 80px; }
        th:nth-child(6), td:nth-child(6) { width: 40px; }

        /* Scrollbar */
        .scrollbar-container {
            position: absolute;
            right: 0;
            top: 0;
            width: 16px;
            height: 100%;
            background-color: #e0e0e0;
            border-left: 1px solid #808080;
        }

        .scrollbar-arrow {
            width: 16px;
            height: 16px;
            background-color: #e0e0e0;
            border: 1px solid #808080;
            border-top-color: #c0c0c0;
            border-left-color: #c0c0c0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            cursor: pointer;
            margin: -1px 0;
        }

        .scrollbar-arrow:active {
            border-top-color: #808080;
            border-left-color: #808080;
            border-bottom-color: #c0c0c0;
            border-right-color: #c0c0c0;
        }

        .scrollbar-track {
            flex: 1;
            background-color: #e0e0e0;
            position: relative;
        }

        .scrollbar-thumb {
            width: 14px;
            height: 40px;
            background-color: #c0c0c0;
            border: 1px solid #808080;
            border-top-color: #e0e0e0;
            border-left-color: #e0e0e0;
            margin: 1px;
            cursor: pointer;
            position: absolute;
            top: 10px;
        }

        /* Button Section */
        .button-section {
            display: flex;
            justify-content: space-between;
        }

        .action-btn {
            background-color: #e0e0e0;
            border: 1px solid #808080;
            border-top-color: #c0c0c0;
            border-left-color: #c0c0c0;
            padding: 4px 20px;
            font-size: 11px;
            cursor: pointer;
            height: 22px;
        }

        .action-btn:active {
            border-top-color: #808080;
            border-left-color: #808080;
            border-bottom-color: #c0c0c0;
            border-right-color: #c0c0c0;
        }

        /* Icons in rightmost column */
        .icon-cell {
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        /* Responsive adjustments */
        @media screen and (max-width: 600px) {
            .main-container {
                width: 100%;
                max-width: 480px;
                min-width: 320px;
            }
            
            body {
                padding: 5px;
            }
        }

        @media screen and (max-width: 400px) {
            .main-container {
                width: 100%;
            }
            
            .content-area {
                padding: 5px;
            }
            
            th, td {
                font-size: 10px;
                padding: 1px 2px;
            }
            
            .tab {
                font-size: 10px;
                padding: 2px 4px;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Header Tabs -->
        <div class="header-tabs">
            <div class="tab">MBS</div>
            <div class="tab">納品書一覧</div>
            <div class="tab">ホーム＞一覧確認＞納品書一覧</div>
        </div>

        <div class="content-area">
            <!-- Search Section -->
            <div class="search-section">
                <div class="search-icon">🔍</div>
                <input type="text" id="searchInput" placeholder="検索キーワード" style="
                    border: 1px solid #808080;
                    border-top-color: #404040;
                    border-left-color: #404040;
                    padding: 2px 4px;
                    font-size: 11px;
                    height: 18px;
                    width: 150px;
                    background-color: white;
                ">
                <button class="search-btn" onclick="searchItems()">検索</button>
            </div>

            <!-- Data Table -->
            <div class="table-container">
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>納品書ID</th>
                                <th>得意先ID</th>
                                <th>得意先名</th>
                                <th>金額</th>
                                <th>納品日</th>
                                <th>備考</th>
                            </tr>
                        </thead>
                        <tbody id="dataTable">
                            <tr class="row-normal" onclick="selectRow(this)">
                                <td>98</td>
                                <td>10001</td>
                                <td>大谷建設（株）</td>
                                <td>20000</td>
                                <td>2024/11/18</td>
                                <td class="icon-cell">📝</td>
                            </tr>
                            <tr class="row-selected" onclick="selectRow(this)">
                                <td>110</td>
                                <td>20000</td>
                                <td>大谷菓子</td>
                                <td>13000</td>
                                <td>2024/11/20</td>
                                <td class="icon-cell">📝</td>
                            </tr>
                            <tr class="row-normal" onclick="selectRow(this)">
                                <td>123</td>
                                <td>30010</td>
                                <td>大谷菓子店</td>
                                <td>2300</td>
                                <td>2024/11/25</td>
                                <td class="icon-cell">📝</td>
                            </tr>
                            <tr class="row-normal" onclick="selectRow(this)">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="icon-cell"></td>
                            </tr>
                            <tr class="row-normal" onclick="selectRow(this)">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="icon-cell"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Scrollbar -->
                <div class="scrollbar-container">
                    <div class="scrollbar-arrow" onclick="scrollUp()">▲</div>
                    <div class="scrollbar-track">
                        <div class="scrollbar-thumb"></div>
                    </div>
                    <div class="scrollbar-arrow" onclick="scrollDown()">▼</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="button-section">
                <button class="action-btn" onclick="goBack()">戻る</button>
                <button class="action-btn" onclick="showDetails()">詳細</button>
            </div>
        </div>
    </div>

    <script>
        // Row selection functionality
        function selectRow(row) {
            // Remove selection from all rows
            const rows = document.querySelectorAll('#dataTable tr');
            rows.forEach(r => {
                r.classList.remove('row-selected');
                r.classList.add('row-normal');
            });

            // Add selection to clicked row
            row.classList.remove('row-normal');
            row.classList.add('row-selected');
        }

        // Search functionality
        function searchItems() {
            const searchTerm = document.getElementById('searchInput').value;
            if (searchTerm.trim()) {
                alert('「' + searchTerm + '」で検索機能が実行されました');
            } else {
                alert('検索キーワードを入力してください');
            }
        }

        // Scroll functions
        function scrollUp() {
            const container = document.querySelector('.table-wrapper');
            container.scrollTop -= 20;
        }

        function scrollDown() {
            const container = document.querySelector('.table-wrapper');
            container.scrollTop += 20;
        }

        // Button actions
        function goBack() {
            alert('戻る機能が実行されました');
        }

        function showDetails() {
            const selectedRow = document.querySelector('.row-selected');
            if (selectedRow) {
                const id = selectedRow.cells[0].textContent;
                if (id.trim()) {
                    alert('納品書ID ' + id + ' の詳細を表示します');
                } else {
                    alert('項目を選択してください');
                }
            } else {
                alert('項目を選択してください');
            }
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const selectedRow = document.querySelector('.row-selected');
            const allRows = document.querySelectorAll('#dataTable tr');
            
            if (e.key === 'ArrowDown') {
                e.preventDefault();
                let nextRow = selectedRow ? selectedRow.nextElementSibling : allRows[0];
                if (nextRow) selectRow(nextRow);
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                let prevRow = selectedRow ? selectedRow.previousElementSibling : allRows[allRows.length - 1];
                if (prevRow) selectRow(prevRow);
            } else if (e.key === 'Enter') {
                e.preventDefault();
                showDetails();
            } else if (e.key === 'Escape') {
                e.preventDefault();
                goBack();
            }
        });

        // Initialize with second row selected (as shown in image)
        document.addEventListener('DOMContentLoaded', function() {
            const secondRow = document.querySelectorAll('#dataTable tr')[1];
            if (secondRow) {
                selectRow(secondRow);
            }
        });
    </script>
</body>

</html>