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
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background-color: #e5e5e5;
            height: 100vh;
            overflow: hidden; /* 外側のスクロールを無効化 */
        }

        main {
            background: white;
            height: calc(100vh - 60px);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            overflow: hidden; /* メインコンテンツのスクロールも無効化 */
        }

        .inner-content {
            background: #f8f8f8;
            padding: 40px;
            border-radius: 4px;
            width: 100%;
            max-width: 1000px;
        }

        .page-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 40px;
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            width: 100%;
        }

        .menu-card {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 30px;
            text-decoration: none;
            color: #333;
            transition: all 0.2s ease;
            display: block;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            min-height: 120px;
            aspect-ratio: 2.5/1;
        }

        .menu-card:hover {
            border-color: #28a745;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.15);
            transform: translateY(-2px);
            text-decoration: none;
            color: #333;
        }

        .menu-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
            color: #333;
        }

        .menu-description {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
        }

        /* レスポンシブ対応 */
        @media (max-width: 768px) {
            .menu-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            main {
                padding: 20px;
                align-items: flex-start;
            }
            
            .inner-content {
                padding: 20px;
            }
            
            .page-title {
                font-size: 20px;
                margin-bottom: 30px;
            }
        }
    </style>
</head>
<body>
    <?= $this->element('header') ?>
    
    <main>
        <div class="inner-content">
            <div class="menu-grid">
                <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'customer']) ?>" class="menu-card">
                    <div class="menu-title">顧客管理</div>
                    <div class="menu-description">顧客情報の登録、検索、編集を行います。</div>
                </a>
                
                <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'order']) ?>" class="menu-card">
                    <div class="menu-title">注文書管理</div>
                    <div class="menu-description">注文書の作成、検索、詳細確認を行います。</div>
                </a>
                
                <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'product']) ?>" class="menu-card">
                    <div class="menu-title">納品管理</div>
                    <div class="menu-description">納品情報の登録、確認、返品処理を行います。</div>
                </a>
                
                <a href="<?= $this->Url->build(['controller' => 'CustomerStats', 'action' => 'index']) ?>" class="menu-card">
                    <div class="menu-title">統計情報</div>
                    <div class="menu-description">売上やリードタイムなどの統計情報を確認します。</div>
                </a>
            </div>
        </div>
    </main>
</body>
</html>