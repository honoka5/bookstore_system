<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>納品書詳細</title>
    <style>
        body {
            font-family: "MS UI Gothic", sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .main-container {
            max-width: 700px;
            margin: 32px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
            padding: 32px;
        }
        h2 {
            margin-top: 0;
            color: #000000;
        }
        .info-list p {
            margin: 6px 0;
            font-size: 15px;
            color: #000000;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 18px;
        }
        th, td {
            border: 1px solid #888;
            padding: 6px 10px;
            font-size: 14px;
            text-align: center;
        }
        th {
            background: #e3f2fd;
            font-weight: bold;
            color: #000000;
        }
        tfoot td {
            background: #f9f9f9;
            font-weight: bold;
        }
        .button-area {
            margin-top: 24px;
            display: flex;
            gap: 24px;
            justify-content: flex-start;
        }
        .button, .action-btn {
            background-color: #6c757d;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 32px;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.2s;
            text-decoration: none;
            display: inline-block;
        }
        .button:hover, .action-btn:hover {
            background-color: #5a6268;
        }
        .action-btn {
            background-color: #1976d2;
        }
        .action-btn:hover {
            background-color: #1565c0;
        }

        /* 印刷用スタイル */
        @media print {
            /* ページ設定：URLやタイトルを非表示 */
            @page {
                margin: 1cm;
                size: A4;
                /* ヘッダーとフッターを非表示 */
                @top-left { content: ""; }
                @top-center { content: ""; }
                @top-right { content: ""; }
                @bottom-left { content: ""; }
                @bottom-center { content: ""; }
                @bottom-right { content: ""; }
            }
            
            body {
                background-color: white;
                margin: 0;
                padding: 0;
                padding-top: 0 !important;
            }
            
            .main-container {
                max-width: none;
                margin: 0;
                background: white;
                border-radius: 0;
                box-shadow: none;
                padding: 20px;
            }
            
            h2 {
                color: black;
            }
            
            th {
                background: #f0f0f0 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            
            tfoot td {
                background: #f5f5f5 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            
            /* common_headerを含む全てのヘッダー要素を印刷時に非表示 */
            .navbar {
                display: none !important;
            }
            
            nav {
                display: none !important;
            }
            
            header {
                display: none !important;
            }
            
            /* common_headerで作成される要素を直接指定 */
            .navbar-brand {
                display: none !important;
            }
            
            /* ヘッダー関連のクラスを全て非表示 */
            [class*="navbar"],
            [class*="header"],
            [class*="nav-"] {
                display: none !important;
            }
            
            /* ボタンエリアを印刷時に非表示 */
            .button-area {
                display: none !important;
            }
            
            /* ボタン個別でも非表示 */
            .button, .action-btn {
                display: none !important;
            }
        }
    </style>
    <script>
        // 印刷時にページタイトルを一時的に変更し、印刷設定を調整
        function printDocument() {
            const originalTitle = document.title;
            document.title = '';  // タイトルを空にする
            
            // 印刷設定のスタイルを動的に追加
            const printStyle = document.createElement('style');
            printStyle.innerHTML = `
                @media print {
                    @page {
                        margin: 1cm;
                        size: A4;
                    }
                    html, body {
                        -webkit-print-color-adjust: exact;
                        color-adjust: exact;
                    }
                }
            `;
            document.head.appendChild(printStyle);
            
            setTimeout(() => {
                window.print();
                // 印刷ダイアログが開いた後にタイトルとスタイルを元に戻す
                setTimeout(() => {
                    document.title = originalTitle;
                    document.head.removeChild(printStyle);
                }, 100);
            }, 100);
        }
    </script>
</head>
<body>
    <?= $this->element('common_header') ?>
    
    <div class="main-container">
        <h2>納品書詳細</h2>
        <div class="info-list">
            <p>納品書ID: <?= h($delivery->delivery_id) ?></p>
            <p>顧客ID: <?= h($delivery->customer_id) ?></p>
            <p>顧客名: <?= h($delivery->customer->name ?? '') ?> 様</p>
            <p>納品日: <?php
                // 納品日を「2025年7月12日」形式で表示
                if (isset($delivery->delivery_date) && $delivery->delivery_date) {
                    $date = $delivery->delivery_date;
                    if (is_string($date)) {
                        $dateObj = new DateTime($date);
                    } else {
                        $dateObj = $date;
                    }
                    echo h($dateObj->format('Y年n月j日'));
                }
            ?></p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>書籍名</th>
                    <th>数量</th>
                    <th>単価</th>
                    <th>金額</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalQty = 0;
                $totalAmount = 0;
                foreach ($delivery->delivery_items ?? [] as $item):
                    $amount = ($item->book_amount ?? 0) * ($item->unit_price ?? 0);
                    $totalQty += $item->book_amount ?? 0;
                    $totalAmount += $amount;
                ?>
                <tr>
                    <td><?= h($item->book_title) ?></td>
                    <td><?= h($item->book_amount) ?></td>
                    <td><?= h($item->unit_price) ?></td>
                    <td><?= h($amount) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>合計</td>
                    <td><?= h($totalQty) ?></td>
                    <td></td>
                    <td><?= h($totalAmount) ?></td>
                </tr>
            </tfoot>
        </table>
        <div style="margin-top:10px;">
            <span>消費税率: 10%</span>
            <span>合計金額: <?= h($totalAmount) ?> 円</span>
        </div>
        <div class="button-area">
            <?= $this->Html->link('戻る', ['controller' => 'List', 'action' => 'product'], ['class' => 'button']) ?>
            <button class="action-btn" onclick="printDocument()">印刷確認</button>
            <?= $this->Html->link('編集', ['controller' => 'DeliveryList', 'action' => 'editDetail', $delivery->delivery_id], ['class' => 'action-btn']) ?>
        </div>
    </div>
</body>
</html>