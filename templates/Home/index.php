<!-- ナビゲーションバー -->
<div class="navbar">
    <div class="navbar-item">MBS</div>
    <div class="navbar-item">ホーム</div>
    <div class="navbar-item">ホーム</div>
</div>

<!-- メインコンテンツ -->
<div class="button-grid">
    <a href="List/List.php" class="button">一覧確認</a>
    <a href="#" class="button">注文書作成</a>
    <a href="#" class="button">統計情報</a>
    <a href="#" class="button">納品書作成</a>
</div>

<style>
.navbar {
    display: flex;
    border-bottom: 2px solid #333;
    margin-bottom: 40px;
}
.navbar-item {
    border: 1px solid #333;
    padding: 10px 40px;
    font-size: 20px;
    background:rgb(249, 246, 246);
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
    background-color:rgb(248, 247, 247);
    color: black;
    border-radius: 20px;
    text-decoration: none;
    font-size: 28px;
    border: 2px solid #333;
    transition: background 0.2s;
}
.button:hover {
    background-color:lightskyblue;
    color: black;
}
</style>
