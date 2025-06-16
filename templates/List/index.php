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

    <style>
        body {
            font-family: 'MS Gothic', monospace;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .navbar {
            display: flex;
            border-bottom: 2px solid #333;
            margin-bottom: 40px;
        }

        .navbar-item {
            border: 1px solid #333;
            padding: 10px 40px;
            font-size: 20px;
            background: rgb(249, 246, 246);
        }

        .navbar-item:first-child {
            border-left: none;
        }

        .button-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px 80px;
            justify-items: center;
            align-items: center;
            margin: 40px auto;
            max-width: 800px;
        }

        .button {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 250px;
            height: 120px;
            background-color: rgb(248, 247, 247);
            color: black;
            border-radius: 20px;
            text-decoration: none;
            font-size: 28px;
            border: 2px solid #333;
            transition: background 0.2s;
        }

        .button:hover {
            background-color: lightskyblue;
            color: black;
        }

        .back-button-container {
            display: flex;
            justify-content: flex-start;
            margin-top: 60px;
            margin-left: 40px;
        }

        .back-button {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 120px;
            height: 50px;
            background-color: rgb(248, 247, 247);
            color: black;
            border-radius: 10px;
            text-decoration: none;
            font-size: 18px;
            border: 2px solid #333;
            transition: background 0.2s;
        }

        .back-button:hover {
            background-color: lightgray;
            color: black;
        }

        /* 3つのボタンを適切に配置するため、3番目のボタンを中央に配置 */
        .button-grid .button:nth-child(3) {
            grid-column: 1 / -1;
            justify-self: center;
        }
    </style>
</body>

</html>