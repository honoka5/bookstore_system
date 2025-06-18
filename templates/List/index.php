<?php
// List.php - 一覧確認画面
session_start();
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBS - 一覧確認</title>
<<<<<<< Updated upstream
</head>

<body>
    <!-- ナビゲーションバー -->
    <div class="navbar">
        <div class="navbar-item">MBS</div>
        <div class="navbar-item">一覧確認</div>
        <div class="navbar-item">ホーム→一覧確認</div>
    </div>

    <!-- メインコンテンツ -->
    <div class="button-grid">
        <p><?= $this->Html->link('顧客一覧', ['controller' => 'List', 'action' => 'customer'], ['class' => 'button']) ?></p>
        <p><?= $this->Html->link('注文書一覧', ['controller' => 'List', 'action' => 'order'], ['class' => 'button']) ?></p>
        <p><?= $this->Html->link('納品書一覧', ['controller' => 'List', 'action' => 'product'], ['class' => 'button']) ?></p>
    </div>

    <!-- 戻るボタン -->
    <div class="back-button-container">
        <a href="index.php" class="back-button">戻る</a>
    </div>

=======
>>>>>>> Stashed changes
    <style>
        body {
            font-family: 'MS Gothic', monospace;
            margin: 0;
            padding: 24px;
            background-color: #fff;
        }

        .navbar {
            display: flex;
            border: 1.5px solid #222;
            border-bottom: none;
            margin-bottom: 0;
        }

        .navbar-item {
            border-right: 1.5px solid #222;
            border-bottom: 1.5px solid #222;
            padding: 10px 40px;
            font-size: 20px;
            background: #fff;
            box-sizing: border-box;
        }

        .navbar-item:first-child {
            border-left: none;
        }

        .navbar-item:last-child {
            border-right: none;
        }

        .main-box {
            border: 1.5px solid #222;
            margin: 0 auto;
            max-width: 900px;
            min-width: 320px;
            min-height: 600px;
            background: #fff;
            box-sizing: border-box;
            padding-bottom: 40px;
        }

        .button-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 60px;
        }

        .row {
            display: flex;
            justify-content: center;
            gap: 60px;
            margin-bottom: 40px;
        }

        .menu-button {
            width: 320px;
            height: 120px;
            border: 2px solid #222;
            border-radius: 18px;
            background: #fff;
            font-size: 28px;
            font-family: 'MS Gothic', monospace;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #222;
            margin: 0 10px;
            transition: background 0.2s, color 0.2s;
        }

        .menu-button:hover {
            background: #e6e6e6;
            color: #000;
        }

        .back-button-container {
            margin-top: 40px;
            margin-left: 24px;
        }

        .back-button {
            width: 180px;
            height: 48px;
            border: 2px solid #222;
            border-radius: 8px;
            background: #fff;
            font-size: 22px;
            font-family: 'MS Gothic', monospace;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #222;
            transition: background 0.2s, color 0.2s;
        }

        .back-button:hover {
            background: #e6e6e6;
            color: #000;
        }
    </style>
</head>

<body>
    <div class="main-box">
        <div class="navbar">
            <div class="navbar-item">MBS</div>
            <div class="navbar-item">一覧確認</div>
            <div class="navbar-item">ホーム＞一覧確認</div>
        </div>
        <div class="button-area">
            <div class="row">
                <a href="customer_list.php" class="menu-button">顧客一覧</a>
                <a href="order_list.php" class="menu-button">注文書一覧</a>
            </div>
            <div class="row">
                <a href="delivery_list.php" class="menu-button">納品書一覧</a>
            </div>
        </div>
        <div class="back-button-container">
            <a href="index.php" class="back-button">戻る</a>
        </div>
    </div>
</body>

</html>