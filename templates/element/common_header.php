<?php
// 現在のコントローラーとアクションを取得
$currentController = $this->request->getParam('controller');
$currentAction = $this->request->getParam('action');

// ナビゲーションメニューの定義
$navItems = [
    [
        'title' => '注文書管理',
        'controller' => 'List',
        'action' => 'order'
    ],
    [
        'title' => '納品管理',
        'controller' => 'List',
        'action' => 'product'
    ],
    [
        'title' => '統計情報',
        'controller' => 'CustomerStats',
        'action' => 'index'
    ],
    [
        'title' => '顧客管理',
        'controller' => 'List',
        'action' => 'customer'
    ]
];

// アクティブ状態を判定する関数
function isActive($item, $currentController, $currentAction) {
    return ($item['controller'] === $currentController && $item['action'] === $currentAction) ? 'active' : '';
}
?>

<div class="header-bar">
    <div class="logo">MBS 受注・納品管理</div>
    <div class="nav-links">
        <?php foreach ($navItems as $item): ?>
            <a href="<?= $this->Url->build(['controller' => $item['controller'], 'action' => $item['action']]) ?>" 
               class="<?= isActive($item, $currentController, $currentAction) ?>">
                <?= h($item['title']) ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<style>
body {
    margin: 0;
    padding-top: 60px; /* ヘッダー分のパディング */
    font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
}

.header-bar {
    font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
    padding: 10px 20px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    z-index: 1000;
    height: 50px;
}

.header-bar .logo {
    font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
    font-weight: bold;
    font-size: 16px;
    margin-right: 30px;
}

.header-bar .nav-links {
    display: flex;
    gap: 0;
}

.header-bar .nav-links a {
    font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
    color: white;
    text-decoration: none;
    padding: 12px 20px;
    font-size: 14px;
    font-weight: normal;
    transition: background-color 0.2s;
    border-right: 1px solid rgba(255,255,255,0.2);
}

.header-bar .nav-links a:hover {
    background-color: rgba(255,255,255,0.1);
}

.header-bar .nav-links a.active {
    background-color: rgba(255,255,255,0.2);
    font-weight: bold;
}

.header-bar .nav-links a:last-child {
    border-right: none;
}
</style>