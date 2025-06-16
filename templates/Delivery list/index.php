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
            font-family: Arial, sans-serif;
            font-size: 12px;
            background-color: #f0f0f0;
            padding: 20px;
        }

        .container {
            background-color: #f0f0f0;
            border: 2px solid #000;
            width: 480px;
            margin: 0 auto;
        }

        .header-tabs {
            display: flex;
            border-bottom: 1px solid #000;
        }

        .tab {
            padding: 8px 16px;
            background-color: #e0e0e0;
            border-right: 1px solid #000;
            font-size: 11px;
            text-align: center;
            flex: 1;
        }

        .tab:first-child {
            max-width: 80px;
            flex: none;
        }

        .tab:last-child {
            border-right: none;
        }

        .content-area {
            padding: 15px;
            background-color: #f0f0f0;
        }

        .search-section {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            gap: 8px;
        }

        .search-input {
            width: 180px;
            height: 22px;
            border: 1px solid #808080;
            background-color: white;
            padding: 2px 4px;
            font-size: 11px;
        }

        .search-btn {
            background-color: #e0e0e0;
            border: 1px solid #808080;
            padding: 3px 12px;
            font-size: 11px;
            cursor: pointer;
            height: 22px;
        }

        .table-container {
            border: 1px solid #808080;
            background-color: white;
            height: 160px;
            position: relative;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #e0e0e0;
            border: 1px solid #808080;
            padding: 6px 8px;
            text-align: left;
            font-weight: normal;
            font-size: 11px;
            height: 24px;
        }

        td {
            border-right: 1px solid #c0c0c0;
            border-bottom: 1px solid #c0c0c0;
            padding: 4px 8px;
            font-size: 11px;
            height: 20px;
        }

        .row-selected td {
            background-color: #316AC5;
            color: white;
        }

        .row-normal:hover td {
            background-color: #f0f0f0;
            cursor: pointer;
        }

        .scrollbar-container {
            position: absolute;
            right: 0;
            top: 0;
            width: 16px;
            height: 100%;
            background-color: #e0e0e0;
            border-left: 1px solid #808080;
        }

        .scrollbar-thumb {
            width: 14px;
            height: 40px;
            background-color: #c0c0c0;
            border: 1px solid #808080;
            margin: 1px;
            cursor: pointer;
        }

        .scrollbar-arrow {
            width: 14px;
            height: 16px;
            background-color: #e0e0e0;
            border: 1px solid #808080;
            margin: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 8px;
            cursor: pointer;
        }

        .button-section {
            display: flex;
            justify-content: space-between;
        }

        .action-btn {
            background-color: #e0e0e0;
            border: 1px solid #808080;
            padding: 6px 20px;
            font-size: 11px;
            cursor: pointer;
            min-width: 50px;
        }

        .action-btn:active {
            background-color: #d0d0d0;
        }

        /* テーブルの幅調整 */
        th:nth-child(1),
        td:nth-child(1) {
            width: 80px;
        }

        th:nth-child(2),
        td:nth-child(2) {
            width: 140px;
        }

        th:nth-child(3),
        td:nth-child(3) {
            width: 80px;
        }

        th:nth-child(4),
        td:nth-child(4) {
            width: 100px;
        }

        th:nth-child(5),
        td:nth-child(5) {
            width: 80px;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Tabs -->
        <div class="header-tabs">
            <div class="tab">MBS</div>
            <div class="tab">納品書一覧</div>
            <div class="tab">ホーム>一覧確認>納品書一覧</div>
        </div>

        <div class="content-area">
            <!-- Search Section -->
            <div class="search-section">
                <input type="text" class="search-input" placeholder="">
                <button class="search-btn" onclick="searchItems()">検索</button>
            </div>

            <!-- Data Table -->
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>納品書ID</th>
                            <th>納客名</th>
                            <th>金額</th>
                            <th>納品日</th>
                            <th>備考</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        <tr class="row-normal" onclick="selectRow(this)">
                            <td>98</td>
                            <td>大谷建設（株）</td>
                            <td>20000</td>
                            <td>2024/11/18</td>
                            <td></td>
                        </tr>
                        <tr class="row-selected" onclick="selectRow(this)">
                            <td>110</td>
                            <td>大谷自菓子</td>
                            <td>13000</td>
                            <td>2024/11/20</td>
                            <td></td>
                        </tr>
                        <tr class="row-normal" onclick="selectRow(this)">
                            <td>123</td>
                            <td>大谷自菓子</td>
                            <td>2300</td>
                            <td>2024/11/25</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <div class="scrollbar-container">
                    <div class="scrollbar-arrow" onclick="scrollUp()">▲</div>
                    <div class="scrollbar-thumb"></div>
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
            const searchValue = document.querySelector('.search-input').value;
            if (searchValue) {
                alert('検索: ' + searchValue);
            }
        }

        // Scroll functions
        function scrollUp() {
            const container = document.querySelector('.table-container');
            container.scrollTop -= 20;
        }

        function scrollDown() {
            const container = document.querySelector('.table-container');
            container.scrollTop += 20;
        }

        // Button actions
        function goBack() {
            alert('戻る機能');
        }

        function showDetails() {
            const selectedRow = document.querySelector('.row-selected');
            if (selectedRow) {
                const id = selectedRow.cells[0].textContent;
                alert('納品書ID ' + id + ' の詳細表示');
            } else {
                alert('項目を選択してください');
            }
        }
    </script>
</body>

</html>