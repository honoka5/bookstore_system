<h1>顧客選択</h1>
<form method="get">
    <input type="text" name="keyword" id="keyword" value="<?= h($keyword ?? '') ?>" placeholder="顧客名で検索">
    <button type="submit">検索</button>
</form>

<?php if (isset($keyword) && $keyword !== null && $keyword === ''): ?>
    <script>alert('顧客名を入力してください');</script>
<?php endif; ?>

<?php if (!empty($keyword)): ?>
    <?php if (empty($customers) || count($customers->toArray()) === 0): ?>
        <p style="color:red;">顧客が見つかりませんでした</p>
    <?php else: ?>
        <table>
            <tr><th>顧客名</th><th>電話番号</th><th>住所</th><th>操作</th></tr>
            <?php foreach ($customers as $customer): ?>
            <tr>
                <td><?= h($customer->customer_name) ?></td>
                <td><?= h($customer->phone_number) ?></td>
                <td><?= h($customer->address) ?></td>
                <td><?= $this->Html->link('選択', ['action' => 'newOrder', $customer->customer_id]) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php endif; ?>
<!-- 戻るボタンを左下に配置 -->
<div class="bottom-left-btn">
    <?= $this->Html->link('戻る', ['controller' => 'Home', 'action' => 'index'], ['class' => 'button']) ?>
</div>
<style>

.bottom-left-btn {
    position: fixed;
    left: 20px;
    bottom: 20px;
    z-index: 100;
}
</style>
