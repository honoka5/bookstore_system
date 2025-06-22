<h1>顧客選択</h1>
<form method="get" onsubmit="return checkKeyword();">
    <input type="text" name="keyword" id="keyword" value="<?= h($keyword ?? '') ?>" placeholder="顧客名で検索">
    <button type="submit">検索</button>
</form>

<?php
// 検索ボタンを押さなくてもリストが表示されるように修正
if (empty($keyword)) {
    // 検索キーワードが空の場合も全件ページング表示
    $showList = true;
} else {
    $showList = true;
}
?>
<?php if ($showList): ?>
    <?php if (empty($customers) || count($customers->toArray()) === 0): ?>
        <p style="color:red;">顧客が見つかりませんでした</p>
    <?php else: ?>
        <table>
            <tr>
                <th>顧客ID</th>
                <th>顧客名</th>
                <th>電話番号</th>
                <th>担当者名</th>
                <th>操作</th>
            </tr>
            <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?= h($customer->customer_id) ?></td>
                    <td><?= h($customer->Name) ?></td>
                    <td><?= h($customer->Phone_Number) ?></td>
                    <td><?= h($customer->Contact_Person) ?></td>
                    <td><?= $this->Html->link('選択', ['action' => 'newOrder', $customer->customer_id]) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
        // ページング矢印
        $totalPages = ceil($total / $limit);
        $baseUrl = $this->Url->build([
            'action' => 'selectCustomer',
        ]);
        $queryParams = $_GET;
        unset($queryParams['page']);
        $queryStr = http_build_query($queryParams);
        ?>
        <div style="margin-top:10px; text-align:center;">
            <?php if ($page > 1): ?>
                <a href="<?= $baseUrl . ($queryStr ? ('?' . $queryStr . '&') : '?') . 'page=' . ($page - 1) ?>">&lt; 前へ</a>
            <?php endif; ?>
            <span> <?= $page ?> / <?= $totalPages ?> </span>
            <?php if ($page < $totalPages): ?>
                <a href="<?= $baseUrl . ($queryStr ? ('?' . $queryStr . '&') : '?') . 'page=' . ($page + 1) ?>">次へ &gt;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<!-- 戻るボタンを左下に配置 -->
<div class="bottom-left-btn">
    <?= $this->Html->link('戻る', ['controller' => 'Home', 'action' => 'index'], ['class' => 'button']) ?>
</div>
<script>
    function checkKeyword() {
        var kw = document.getElementById('keyword').value.trim();
        if (kw === '') {
            alert('顧客名を入力してください');
            return false;
        }
        return true;
    }
</script>
<style>
    .bottom-left-btn {
        position: fixed;
        left: 20px;
        bottom: 20px;
        z-index: 100;
    }
</style>