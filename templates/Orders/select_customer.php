<h1>顧客選択</h1>
<table>
    <tr><th>ID</th><th>顧客名</th><th>住所</th><th>操作</th></tr>
    <?php foreach ($customers as $customer): ?>
    <tr>
        <td><?= h($customer->customer_id) ?></td>
        <td><?= h($customer->customer_name) ?></td>
        <td><?= h($customer->address) ?></td>
        <td><?= $this->Html->link('選択', ['action' => 'new_order', $customer->customer_id]) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

