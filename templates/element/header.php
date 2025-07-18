<style>
body {
    margin: 0;
    padding-top: 60px; /* ヘッダー分のパディング */
}

.navbar {
    background: #28a745;
    color: white;
    padding: 15px 20px;
    font-size: 18px;
    font-weight: bold;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    z-index: 1000;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.navbar-brand {
    color: white;
    text-decoration: none;
    font-size: 18px;
    font-weight: bold;
}

.navbar-brand:hover {
    color: white;
    text-decoration: none;
}
</style>

<nav class="navbar">
    <?= $this->Html->link('MBS 受注・納品管理', ['controller' => 'Home', 'action' => 'index'], ['class' => 'navbar-brand']) ?>
</nav>