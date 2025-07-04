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
            font-size: 20px;
            background-color: rgb(251, 250, 250);
            padding: 0;
            min-height: 100vh;
            width: 100vw;
            box-sizing: border-box;
        }
 
        .main-container {
            background-color: rgb(253, 251, 251);
            border: 2px solid #000;
            width: 1524px;
            min-width: 0;
            min-height: 100vh;
            margin: 0 0 0 -220px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            border-radius: 0;
            padding-bottom: 40px;
            box-sizing: border-box;
        }
 
        .header-tabs {
            display: flex;
            border-bottom: 1px solid #000;
            font-size: 22px;
            height: 60px;
        }
 
        .tab {
            padding: 16px 32px;
            background-color:rgb(42, 205, 110);
            border-right: 1px solid #000;
            font-size: 20px;
            text-align: center;
            flex: 1;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: flex;
            align-items: center;
            justify-content: center;
        }
 
        .tab:first-child {
            max-width: 120px;
            flex: 0 0 auto;
        }
 
        .tab:last-child {
            border-right: none;
        }
 
        .content-area {
            padding: 40px 30px 0 30px;
            background-color:rgb(255, 255, 255);
        }
 
        .button-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 40px 60px;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
        }
 
        .menu-button {
            background-color: rgb(250, 248, 248);
            border: 2px solid #808080;
            padding: 0;
            font-size: 32px;
            font-weight: bold;
            color: #000;
            text-align: center;
            cursor: pointer;
            min-height: 180px;
            min-width: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
            word-wrap: break-word;
            text-decoration: none;
            border-radius: 18px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
        }
 
        .menu-button:hover {
            background-color: #87cefa;
            color:rgb(0, 0, 0);
            box-shadow: 0 4px 16px rgba(0, 209, 241, 0.15);
        }
 
        .menu-button:active {
            background-color:rgb(255, 254, 254);
        }
 
        @media (max-width: 900px) {
            .main-container {
                max-width: 98vw;
                margin: 10px;
            }
 
            .button-grid {
                gap: 20px 10px;
            }
 
            .menu-button {
                min-width: 140px;
                font-size: 20px;
                min-height: 100px;
            }
 
            .header-tabs {
                font-size: 16px;
                height: 40px;
            }
 
            .tab {
                font-size: 14px;
                padding: 8px 10px;
            }
        }
 
        @media (max-width: 600px) {
            .button-grid {
                grid-template-columns: 1fr;
                grid-template-rows: repeat(4, 1fr);
                gap: 16px;
            }
 
            .menu-button {
                min-width: 80px;
                font-size: 16px;
                min-height: 60px;
            }
 
            .content-area {
                padding: 10px 2px 0 2px;
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
                <p><?= $this->Html->link('統計情報', ['controller' => 'CustomerStats', 'action' => 'index'], ['class' => 'menu-button']) ?></p>
                <p><?= $this->Html->link('納品書作成', ['controller' => 'RegDeliveries', 'action' => 'select_customer'], ['class' => 'menu-button']) ?></p>
            </div>
        </div>
    </div>
</body>
 
</html>
 