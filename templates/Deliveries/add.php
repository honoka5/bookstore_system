<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBS注文者作成画面</title>
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
            margin-bottom: 8px;
        }

        .search-label {
            font-size: 11px;
            margin-bottom: 4px;
        }

        .search-row {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .search-label-inline {
            font-size: 11px;
        }

        .search-input {
            border: 1px solid #808080;
            border-top-color: #404040;
            border-left-color: #404040;
            padding: 2px 4px;
            font-size: 11px;
            height: 18px;
            width: 120px;
            background-color: white;
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

        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .data-table th {
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

        .data-table td {
            border-right: 1px solid #e0e0e0;
            border-bottom: 1px solid #e0e0e0;
            padding: 1px 4px;
            height: 16px;
            font-size: 11px;
            background-color: white;
        }

        /* Row Selection */
        .data-table tr.selected {
            background-color: #0066cc !important;
        }

        .data-table tr.selected td {
            background-color: #0066cc !important;
            color: white;
        }

        .data-table tr:not(.selected):hover {
            background-color: #e6f3ff;
        }

        .data-table tr:not(.selected):hover td {
            background-color: #e6f3ff;
        }

        /* Column Widths */
        .data-table th:nth-child(1),
        .data-table td:nth-child(1) {
            width: 60px;
            text-align: center;
        }

        .data-table th:nth-child(2),
        .data-table td:nth-child(2) {
            width: 120px;
        }

        .data-table th:nth-child(3),
        .data-table td:nth-child(3) {
            width: 100px;
            text-align: center;
        }

        .data-table th:nth-child(4),
        .data-table td:nth-child(4) {
            width: 80px;
        }

        /* Scrollbar */
        .scrollbar-container {
            position: absolute;
            right: 0;
            top: 0;
            width: 16px;
            height: 100%;
            background-color: #e0e0e0;
            border-left: 1px solid #808080;
            display: flex;
            flex-direction: column;
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

        .btn {
            background-color: #e0e0e0;
            border: 1px solid #808080;
            border-top-color: #c0c0c0;
            border-left-color: #c0c0c0;
            padding: 4px 20px;
            font-size: 11px;
            cursor: pointer;
            height: 22px;
        }

        .btn:active {
            border-top-color: #808080;
            border-left-color: #808080;
            border-bottom-color: #c0c0c0;
            border-right-color: #c0c0c0;
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
            
            .data-table th, .data-table td {
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
            <div class="tab">納品書作成</div>
            <div class="tab">ホーム＞納品書作成</div>
        </div>

        <div class="content-area">
            <!-- Search Section -->
            <div class="search-section">
                <div class="search-label">顧客を選択してください</div>
                <div class="search-row">
                    <span class="search-label-inline">顧客情報：</span>
                    <input type="text" class="search-input" value="">
                    <button class="search-btn">検索</button>
                </div>
            </div>

            <!-- Data Table -->
            <div class="table-container">
                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>顧客ID</th>
                                <th>顧客名</th>
                                <th>電話番号</th>
                                <th>住所</th>
                            </tr>
                        </thead>
                        <tbody id="customerTable">
                            <tr>
                                <td>10001</td>
                                <td>大谷翔平（株）</td>
                                <td>XXXXXXXXXXXX</td>
                                <td>0府0市XX</td>
                            </tr>
                            <tr class="selected">
                                <td>20004</td>
                                <td>大谷翔平株式</td>
                                <td>YYYYYYYYYYYY</td>
                                <td>0府0市YY</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Scrollbar -->
                <div class="scrollbar-container">
                    <div class="scrollbar-arrow">▲</div>
                    <div class="scrollbar-track">
                        <div class="scrollbar-thumb"></div>
                    </div>
                    <div class="scrollbar-arrow">▼</div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="button-section">
                <button class="btn">戻る</button>
                <button class="btn">次へ</button>
            </div>
        </div>
    </div>

    <script>
        // テーブルの行をクリックしたときの処理
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#customerTable tr');

            rows.forEach(row => {
                row.addEventListener('click', function() {
                    // 空の行はスキップ
                    if (!this.cells[0].textContent.trim()) return;
                    
                    // 他の行の選択を解除
                    rows.forEach(r => r.classList.remove('selected'));
                    // クリックした行を選択
                    this.classList.add('selected');
                });
            });

            // 検索ボタンの処理
            document.querySelector('.search-btn').addEventListener('click', function() {
                const searchTerm = document.querySelector('.search-input').value;
                if (searchTerm) {
                    alert('「' + searchTerm + '」で検索機能が実行されました');
                } else {
                    alert('検索キーワードを入力してください');
                }
            });

            // Enterキーでの検索
            document.querySelector('.search-input').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.querySelector('.search-btn').click();
                }
            });

            // 戻るボタンの処理
            document.querySelectorAll('.btn')[0].addEventListener('click', function() {
                alert('戻る機能が実行されました');
            });

            // 次へボタンの処理
            document.querySelectorAll('.btn')[1].addEventListener('click', function() {
                const selectedRow = document.querySelector('#customerTable tr.selected');
                if (selectedRow && selectedRow.cells[0].textContent.trim()) {
                    const customerId = selectedRow.cells[0].textContent;
                    const customerName = selectedRow.cells[1].textContent;
                    alert('顧客ID ' + customerId + ' (' + customerName + ') を選択して次へ進みます');
                } else {
                    alert('顧客を選択してください');
                }
            });

            // スクロールバーの処理
            const scrollArrows = document.querySelectorAll('.scrollbar-arrow');
            const tableWrapper = document.querySelector('.table-wrapper');
            
            scrollArrows[0].addEventListener('click', function() {
                tableWrapper.scrollTop -= 20;
            });
            
            scrollArrows[1].addEventListener('click', function() {
                tableWrapper.scrollTop += 20;
            });

            // キーボードナビゲーション
            document.addEventListener('keydown', function(e) {
                const selectedRow = document.querySelector('#customerTable tr.selected');
                const allRows = document.querySelectorAll('#customerTable tr');
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    let nextRow = selectedRow ? selectedRow.nextElementSibling : allRows[0];
                    if (nextRow && nextRow.cells[0].textContent.trim()) {
                        allRows.forEach(r => r.classList.remove('selected'));
                        nextRow.classList.add('selected');
                    }
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    let prevRow = selectedRow ? selectedRow.previousElementSibling : allRows[allRows.length - 1];
                    if (prevRow && prevRow.cells[0].textContent.trim()) {
                        allRows.forEach(r => r.classList.remove('selected'));
                        prevRow.classList.add('selected');
                    }
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    document.querySelectorAll('.btn')[1].click();
                } else if (e.key === 'Escape') {
                    e.preventDefault();
                    document.querySelectorAll('.btn')[0].click();
                }
            });
        });
    </script>
</body>

</html>