<script>
// 顧客テーブルの行クリックで遷移（aタグ以外）
document.addEventListener('DOMContentLoaded', function() {
    var rows = document.querySelectorAll('#customer-table .selectable-row');
    rows.forEach(function(row) {
        row.style.cursor = 'pointer';
        row.querySelectorAll('td').forEach(function(td) {
            td.addEventListener('click', function(e) {
                if (e.target.tagName.toLowerCase() === 'a') return;
                window.location = row.getAttribute('data-href');
            });
        });
    });
});
</script>
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
    <?php
    // 納品内容のis_delivered_flag=0が1件でもある顧客のみ表示
    $filteredCustomers = [];
    if (!empty($customers)) {
        // customersはResultSetまたは配列
        foreach ($customers as $customer) {
            // DeliveryItemsテーブルを直接参照
            $deliveryItemsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('DeliveryItems');
            // 顧客の注文書ID一覧を取得
            $orderTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Orders');
            $orderIds = $orderTable->find()
                ->select(['order_id'])
                ->where(['customer_id' => $customer->customer_id])
                ->enableHydration(false)
                ->all()
                ->map(function($row){ return $row['order_id']; })
                ->toList();
            if (empty($orderIds)) continue;
            // その注文書IDに紐づく未納品納品内容が1件でもあれば表示
            $hasUndelivered = false;
            if (!empty($orderIds)) {
                // order_itemsからorder_id IN $orderIdsのorderItem_id一覧を取得
                $orderItemsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('OrderItems');
                $orderItemIds = $orderItemsTable->find()
                    ->select(['orderItem_id'])
                    ->where(['order_id IN' => $orderIds])
                    ->enableHydration(false)
                    ->all()
                    ->map(function($row){ return $row['orderItem_id']; })
                    ->toList();
                if (!empty($orderItemIds)) {
                    $hasUndelivered = $deliveryItemsTable->find()
                        ->where([
                            'DeliveryItems.is_delivered_flag' => 0,
                            'DeliveryItems.orderItem_id IN' => $orderItemIds
                        ])
                        ->count() > 0;
                }
            }
            if ($hasUndelivered) {
                $filteredCustomers[] = $customer;
            }
        }
    }
    ?>
    <?php if (empty($filteredCustomers)): ?>
        <p style="color:red;">未納品のある顧客が見つかりませんでした</p>
    <?php else: ?>
        <table id="customer-table">
            <tr>
                <th>顧客ID</th>
                <th>顧客名</th>
                <th>電話番号</th>
                <th>担当者名</th>
                <th>操作</th>
            </tr>
            <?php foreach ($filteredCustomers as $customer): ?>
                <tr class="selectable-row" data-href="<?= $this->Url->build(['action' => 'select_deliveries', $customer->customer_id]) ?>">
                    <td><?= h($customer->customer_id) ?></td>
                    <td><?= h($customer->name) ?></td>
                    <td><?= h($customer->phone_number) ?></td>
                    <td><?= h($customer->contact_person) ?></td>
                    <td><?= $this->Html->link('選択', ['action' => 'select_deliveries', $customer->customer_id]) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php
        // ページング矢印
        $baseUrl = $this->Url->build([
            'action' => 'select_customer',
        ]);
        $queryParams = $_GET;
        unset($queryParams['page']);
        $queryStr = http_build_query($queryParams);
        // ページング用にfilteredCustomersを分割
        $filteredTotal = count($filteredCustomers);
        $limit = $limit ?? 10;
        $page = $page ?? 1;
        $filteredTotalPages = ($limit > 0) ? (int)ceil($filteredTotal / $limit) : 1;
        $start = ($page - 1) * $limit;
        $pagedCustomers = array_slice($filteredCustomers, $start, $limit);
        ?>
        <div style="margin-top:10px; text-align:center;">
            <?php if ($filteredTotalPages > 1 && $page > 1): ?>
                <a href="<?= $baseUrl . ($queryStr ? ('?' . $queryStr . '&') : '?') . 'page=' . ($page - 1) ?>">&lt; 前へ</a>
            <?php endif; ?>
            <span> <?= $page ?> / <?= $filteredTotalPages ?> </span>
            <?php if ($filteredTotalPages > 1 && $page < $filteredTotalPages): ?>
                <a href="<?= $baseUrl . ($queryStr ? ('?' . $queryStr . '&') : '?') . 'page=' . ($page + 1) ?>">次へ &gt;</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<!-- 戻るボタンを左下に配置 -->
<div class="bottom-left-btn">
    <?= $this->Html->link('戻る', ['controller' => 'DeliveryList', 'action' => 'index'], ['class' => 'button']) ?>
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
    #customer-table .selectable-row:hover {
        background-color:hsl(210, 77.00%, 67.60%);
        transition: background-color 0.2s;
    }
</style>
