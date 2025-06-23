<h1>注文一覧</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>商品名</th>
            <th>数量</th>
            <th>注文日</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= h($order->id) ?></td>
                <td><?= h($order->product_name) ?></td>
                <td><?= h($order->quantity) ?></td>
                <td><?= h($order->order_date) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>