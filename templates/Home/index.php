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
            background: #fff;
            border-radius: 8px 8px 0 0;
            margin: 0 auto;
            max-width: 98vw;
            min-width: 320px;
            min-height: 100vh;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            padding-bottom: 40px;
            box-sizing: border-box;
        }
 
        .header-bar {
            width: 100%;
            background: #219653;
            color: #fff;
            padding: 18px 0 18px 24px;
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            border-radius: 8px 8px 0 0;
            box-sizing: border-box;
        }
 
        .main-title {
            font-size: 48px;
            font-weight: bold;
            margin: 48px 0 32px 0;
            text-align: left;
            letter-spacing: 2px;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 32px 32px;
            max-width: 1400px;
            margin: 0 auto;
        }
        .menu-card {
            background: #fff;
            border: 1.5px solid #ccc;
            border-radius: 8px;
            padding: 32px 32px 24px 32px;
            font-size: 28px;
            font-weight: bold;
            color: #222;
            box-shadow: none;
            min-width: 320px;
            min-height: 80px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            transition: box-shadow 0.2s, border 0.2s;
        }
        .menu-card:hover {
            border: 1.5px solid #219653;
            box-shadow: 0 4px 16px rgba(33, 150, 83, 0.08);
        }
        .menu-desc {
            font-size: 18px;
            font-weight: normal;
            color: #333;
            margin-top: 12px;
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
        <div class="header-bar">MBS 受注・納品管理</div>
        <div class="content-area" style="padding: 0 0 0 0; background: #fff;">
            <div class="main-title">メインメニュー</div>
            <div class="menu-grid">
                <a href="<?= $this->Url->build(['controller' => 'RegOrders', 'action' => 'select_customer']) ?>" class="menu-card">
                    顧客管理
                    <span class="menu-desc">顧客情報の登録、検索、編集を行います。</span>
                </a>
                <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'order']) ?>" class="menu-card">
                    注文書管理
                    <span class="menu-desc">注文書の作成、検索、詳細確認を行います。</span>
                </a>
                <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'product']) ?>" class="menu-card">
                    納品書管理
                    <span class="menu-desc">納品書の登録、確認、返品処理を行います。</span>
                </a>
                <a href="<?= $this->Url->build(['controller' => 'CustomerStats', 'action' => 'index']) ?>" class="menu-card">
                    統計情報
                    <span class="menu-desc">売上やリードタイムなどの統計情報を確認します。</span>
                </a>
            </div>
        </div>
    </div>
</body>
 
</html>
 