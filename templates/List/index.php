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
    <style>
        body {
            font-family: 'MS Gothic', monospace;
            margin: 0;
            padding: 0;
            background-color: #fff;
            min-height: 100vh;

        }

        .navbar {
            display: flex;
    width: 100vw;                   /* 横幅いっぱいに */
    border-bottom: 1.5px solid #222;/* 下線を明示的に指定 */
    margin-bottom: 0;
    box-sizing: border-box;
    border-left: 2px solid #222;    /* 左の枠線も必要なら追加 */
    border-right: 2px solid #222; /* 右の枠線も必要なら追加 */
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
            border: 2px solid #222;
            margin: 0 0 0 -220px ;
            width: 1519px;
            min-width: 0;
            min-height: 100vh;
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
            width: 200px;
            height: 60px;
            border: 2px solid #222;
            border-radius: 8px;
            background-color: #4FC3F7;
            font-size: 24px;
            font-family: 'MS Gothic', monospace;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #fff;
            transition: background 0.2s;
        }

        .back-button:hover {
            background-color: #0288d1;
            
        }
    </style>
<body>
    <?= $this->element('header', ['title' => '一覧確認']) ?>
    <div class="main-box" style="border:2px solid #222;">
        <div class="button-area">
            <div class="row">
                <?= $this->Html->link('顧客一覧', ['controller' => 'List', 'action' => 'customer'], ['class' => 'menu-button']) ?>
                <?= $this->Html->link('注文書一覧', ['controller' => 'List', 'action' => 'order'], ['class' => 'menu-button']) ?>
            </div>
                <div class="row">
                <?= $this->Html->link('納品書一覧', ['controller' => 'List', 'action' => 'product'], ['class' => 'menu-button']) ?>
            </div>
        </div>
        <div class="back-button-container">
            
            <?= $this->Html->link('戻る',['controller' => 'Home', 'action' => 'index'], ['class' => 'button']) ?>
        </div>
    </div>
</body>

</html>