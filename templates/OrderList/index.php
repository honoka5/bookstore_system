<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBS注文管理画面</title>
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

        .main-container {
            background-color: #f0f0f0;
            border: 2px solid #000;
            width: 480px;
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

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background-color: #e0e0e0;
            border: 1px solid #808080;
            padding: 6px 8px;
            text-align: left;
            font-weight: normal;
            font-size: 11px;
            height: 24px;
        }

        .data-table td {
            border-right: 1px solid #c0c0c0;
            border-bottom: 1px solid #c0c0c0;
            padding: 4px 8px;
            font-size: 11px;
            height: 20px;
        }

        .data-table tr.selected td {
            background-color: #316AC5;
            color: white;
        }

        .data-table tr:not(.selected):hover td {
            background-color: #f0f0f0;
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

        .btn {
            background-color: #e0e0e0;
            border: 1px solid #808080;
            padding: 6px 20px;
            font-size: 11px;
            cursor: pointer;
            min-width: 50px;
        }

        .btn:active {
            background-color: #d0d0d0;
        }

        /* テーブルの幅調整 */
        .data-table th:nth-child(1),
        .data-table td:nth-child(1) { width: 80px; }
        .data-table th:nth-child(2),
        .data-table td:nth-child(2) { width: 140px; }
        .data-table th:nth-child(3),
        .data-table td:nth-child(3) { width: 80px; }
        .data-table th:nth-child(4),
        .data-table td:nth-child(4) { width: 100px; }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="header-tabs">
            <div class="tab">MBS</div>
            <div class="tab">注文書一覧</div>
            <div class="tab">ホーム＞一覧確認＞注文書一覧</div>
        </div>

        <div class="content-area">
            <div class="search-section">
                <input type="text" class="search-input">
                <button class="search-btn">検索</button>
            </div>

            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>注文書ID</th>
                            <th>顧客名</th>
                            <th>金額</th>
                            <th>注文日</th>
                        </tr>
                    </thead>
                    <tbody id="orderTable">
                        <tr>
                            <td>99</td>
                            <td>大谷康政（株）</td>
                            <td>20000</td>
                            <td>2024/11/18</td>
                        </tr>
                        <tr class="selected">
                            <td>110</td>
                            <td>大谷真美子</td>
                            <td>13000</td>
                            <td>2024/11/20</td>
                        </tr>
                        <tr>
                            <td>123</td>
                            <td>大谷真美子</td>
                            <td>2300</td>
                            <td>2024/11/25</td>
                        </tr>
                    </tbody>
                </table>
                
                <div class="scrollbar-container">
                    <div class="scrollbar-arrow">▲</div>
                    <div class="scrollbar-thumb"></div>
                    <div class="scrollbar-arrow">▼</div>
                </div>
            </div>

            <div class="button-section">
                <button class="btn">戻る</button>
                <button class="btn">詳細</button>
            </div>
        </div>
    </div>

    <script>
        // テーブルの行をクリックしたときの処理
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('#orderTable tr');
            
            rows.forEach(row => {
                row.addEventListener('click', function() {
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
                    alert('検索: ' + searchTerm);
                }
            });

            // 戻るボタンの処理
            document.querySelectorAll('.btn')[0].addEventListener('click', function() {
                alert('戻る機能');
            });

            // 詳細ボタンの処理
            document.querySelectorAll('.btn')[1].addEventListener('click', function() {
                const selectedRow = document.querySelector('#orderTable tr.selected');
                if (selectedRow) {
                    const orderId = selectedRow.cells[0].textContent;
                    alert('注文書ID ' + orderId + ' の詳細表示');
                } else {
                    alert('行を選択してください');
                }
            });
        });
    </script>
</body>
</html>