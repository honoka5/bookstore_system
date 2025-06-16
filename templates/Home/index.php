<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBS Dashboard</title>
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
            padding: 10px;
            min-height: 100vh;
        }

        .main-container {
            background-color: #f0f0f0;
            border: 2px solid #000;
            width: 100%;
            max-width: 800px;
            min-width: 320px;
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
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .tab:first-child {
            max-width: 80px;
            flex: 0 0 auto;
        }

        .tab:last-child {
            border-right: none;
        }

        .content-area {
            padding: 20px;
            background-color: #f0f0f0;
        }

        .button-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 20px;
            max-width: none;
            width: 100%;
        }

        .menu-button {
            background-color: #e0e0e0;
            border: 1px solid #808080;
            padding: 40px 20px;
            font-size: 14px;
            font-weight: bold;
            color: #000;
            text-align: center;
            cursor: pointer;
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            word-wrap: break-word;
            text-decoration: none; /* 追加: テキストの下線を削除 */
        }

        .menu-button:hover {
            background-color: #d0d0d0;
        }

        .menu-button:active {
            background-color: #c0c0c0;
        }

        /* タブレット以下のサイズ */
        @media (max-width: 768px) {
            body {
                padding: 5px;
                font-size: 11px;
            }

            .main-container {
                border-width: 1px;
            }

            .tab {
                padding: 6px 8px;
                font-size: 10px;
            }

            .content-area {
                padding: 10px;
            }

            .button-grid {
                gap: 10px;
            }

            .menu-button {
                padding: 25px 15px;
                min-height: 80px;
                font-size: 12px;
            }
        }

        /* スマートフォンサイズ */
        @media (max-width: 480px) {
            body {
                padding: 2px;
                font-size: 10px;
            }

            .tab {
                padding: 4px 6px;
                font-size: 9px;
            }

            .tab:first-child {
                max-width: 60px;
            }

            .content-area {
                padding: 8px;
            }

            .button-grid {
                gap: 8px;
            }

            .menu-button {
                padding: 20px 12px;
                min-height: 60px;
                font-size: 11px;
            }
        }

        /* 大画面用 */
        @media (min-width: 1024px) {
            .button-grid {
                max-width: 800px;
            }

            .menu-button {
                min-height: 140px;
                font-size: 16px;
                padding: 50px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <!-- Header Tabs -->
        <div class="header-tabs">
            <div class="tab">MBS</div>
            <div class="tab">ホーム</div>
            <div class="tab">ホーム</div>
        </div>

        <div class="content-area">
            <div class="button-grid">
                <p><?= $this->Html->link('一覧確認', ['controller' => 'List', 'action' => 'index'], ['class' => 'menu-button']) ?></p>
                <p><?= $this->Html->link('注文書作成', ['controller' => 'RegOrders', 'action' => 'select_customer'], ['class' => 'menu-button']) ?></p>
                <p><?= $this->Html->link('統計情報', '#', ['class' => 'menu-button']) ?></p>
                <p><?= $this->Html->link('納品書作成', ['controller' => 'Deliveries', 'action' => 'add'], ['class' => 'menu-button']) ?></p>
            </div>
        </div>
    </div>
</body>

</html>