<?php
// templates/RegDeliveries/select_deliveries.php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $deliveryItems
 * @var int $customerId
 */
?>
<div class="deliveries index content">
    <h3>納品内容選択</h3>
    <?= $this->Form->create(null, ['url' => ['action' => 'registerDeliveries']]) ?>
    <input type="hidden" name="customer_id" value="<?= h($customerId) ?>">
    <div class="table-responsive">
        <?php if (empty($deliveryItems) || count($deliveryItems) === 0): ?>
            <p style="color:red;">未納品の商品はありません</p>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>納品内容ID</th>
                    <th>商品名</th>
                    <th>注文数量</th>
                    <th>納品数量</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // 事前に各orderItem_idごとの納品済み数量合計をコントローラから渡す
                $deliveredSums = $deliveredSums ?? [];
                foreach ($deliveryItems as $item): ?>
                <tr>
                    <td><?= h($item->deliveryItem_id) ?></td>
                    <td><?= h($item->order_item->book_title ?? '') ?></td>
                    <td><?= h($item->order_item->book_amount ?? '') ?></td>
                    <td>
                        <?php
                        $orderItemId = $item->orderItem_id;
                        $orderAmount = (int)($item->order_item->book_amount ?? 0);
                        $deliveredSum = isset($deliveredSums[$orderItemId]) ? (int)$deliveredSums[$orderItemId] : 0;
                        $max = max(0, $orderAmount - $deliveredSum);
                        ?>
                        <select name="quantities[<?= h($item->deliveryItem_id) ?>]">
                            <?php for ($i = 0; $i <= $max; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?></option>
                            <?php endfor; ?>
                        </select>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="text-align: right; margin-top: 1em;">
            <button type="submit" class="btn btn-success">登録</button>
        </div>
        <?php endif; ?>
    </div>
    <?= $this->Form->end() ?>
    <?php $flashMsg = $this->Flash->render(); ?>
    <script>
    <?php if (!empty($flashMsg)): ?>
        window.onload = function() {
            // HTMLタグを除去してメッセージだけ表示
            var msg = '<?= strip_tags(trim($flashMsg)) ?>';
            alert(msg);
        };
    <?php endif; ?>
    </script>
</div>
<div class="bottom-left-btn">
    <?= $this->Html->link('戻る', ['controller' => 'RegDeliveries', 'action' => 'selectCustomer'], ['class' => 'button']) ?>
</div>
<style>
.bottom-left-btn {
    position: fixed;
    left: 20px;
    bottom: 20px;
    z-index: 100;
}
</style>
