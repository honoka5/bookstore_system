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
    <div style="border:2px solid #222; border-radius: 10px; max-width: 1100px; margin: 32px auto 0 auto; background: #fff; box-shadow: 0 2px 16px rgba(0,0,0,0.06); min-height: 90vh; display: flex; flex-direction: column; justify-content: flex-start;">
        <div style="background: #e6f9d7; border-radius: 10px 10px 0 0; border-bottom:2px solid #222; width:100%;">
            
        <?= $this->element('header', ['title' => 'メインメニュー']) ?>
        </div>
        <div class="main-container" style="border:none; border-radius: 0; box-shadow:none; margin:0; min-height:unset; height:auto; padding-bottom:0; max-width:100%;">
            <div class="content-area" style="padding: 0 0 0 0; background: #fff;">
                <div class="main-title" style="font-size:32px; margin:16px 0 24px 0;">メインメニュー</div>
                <div class="menu-grid" style="grid-template-columns: 1fr 1fr; grid-template-rows: 1fr 1fr; gap: 20px 20px; max-width: 700px;">

                    <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'customer']) ?>" class="menu-card" style="font-size:20px; min-width:0; min-height:60px; padding:20px 20px 14px 20px;">
                        顧客管理
                        <span class="menu-desc" style="font-size:17px; margin-top:10px;">顧客情報の登録、検索、編集を行います。</span>
                    </a>
                    <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'order']) ?>" class="menu-card" style="font-size:26px; min-width:380px; min-height:90px; padding:28px 28px 18px 28px; grid-column: 2 / 3; grid-row: 1 / 2;">
                        注文書管理
                        <span class="menu-desc" style="font-size:17px; margin-top:10px;">注文書の作成、検索、詳細確認を行います。</span>
                    </a>

                    <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'product']) ?>" class="menu-card" style="font-size:20px; min-width:0; min-height:60px; padding:20px 20px 14px 20px;">
                        納品書管理
                        <span class="menu-desc" style="font-size:17px; margin-top:10px;">納品書の登録、確認、返品処理を行います。</span>
                    </a>

                    <a href="<?= $this->Url->build(['controller' => 'CustomerStats', 'action' => 'index']) ?>" class="menu-card" style="font-size:20px; min-width:0; min-height:60px; padding:20px 20px 14px 20px;">
                        統計情報
                        <span class="menu-desc" style="font-size:17px; margin-top:10px;">売上やリードタイムなどの統計情報を確認します。</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
 
</html>
 