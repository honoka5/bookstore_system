<div class="header-bar">
    <div class="logo">MBS 受注・納品管理</div>
    <div class="nav-links">
        <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'index']) ?>">受注管理</a>
        <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'order']) ?>">注文発注管理</a>
        <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'product']) ?>">納品管理</a>
        <a href="<?= $this->Url->build(['controller' => 'CustomerStats', 'action' => 'index']) ?>">統計情報</a>
        <a href="<?= $this->Url->build(['controller' => 'List', 'action' => 'customer']) ?>">顧客一覧</a>
    </div>
</div>

<style>
.header-bar {
    background: linear-gradient(135deg, #4CAF50, #45a049);
    color: white;
    padding: 12px 20px;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}

.header-bar .logo {
    font-weight: bold;
    font-size: 18px;
    margin-right: 30px;
}

.header-bar .nav-links {
    display: flex;
    gap: 20px;
}

.header-bar .nav-links a {
    color: white;
    text-decoration: none;
    padding: 8px 12px;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.header-bar .nav-links a:hover {
    background-color: rgba(255,255,255,0.2);
}

.header-bar .nav-links a.active {
    background-color: rgba(255,255,255,0.3);
    font-weight: bold;
}

/* ヘッダー分のマージンを追加 */
body {
    padding-top: 60px;
}
</style>