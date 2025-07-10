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
    <div style="display:flex; justify-content:space-between; align-items:center;">
        <input type="hidden" name="customer_id" value="<?= h($customerId) ?>">
        <div></div>
        <div style="text-align:right;">
            <label for="delivery_date">納品日:</label>
            <input type="date" name="delivery_date" id="delivery_date" value="<?= h(date('Y-m-d')) ?>" style="margin-left:5px;">
        </div>
    </div>
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
                    <th>納品可能数量</th>
                    <th>納品数量</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $deliveredSums = $deliveredSums ?? [];
                $undeliveredSums = $undeliveredSums ?? [];
                foreach ($deliveryItems as $item): ?>
                <tr>
                    <td><?= h($item->deliveryItem_id) ?></td>
                    <td><?= h($item->order_item->book_title ?? '') ?></td>
                    <td><?= h($item->order_item->book_amount ?? '') ?></td>
                    <td><?= h($undeliveredSums[$item->orderItem_id] ?? 0) ?></td>
                    <td>
                        <?php
                        $orderItemId = $item->orderItem_id;
                        $orderAmount = (int)($item->order_item->book_amount ?? 0);
                        $deliveredSum = isset($deliveredSums[$orderItemId]) ? (int)$deliveredSums[$orderItemId] : 0;
                        $max = max(0, $orderAmount - $deliveredSum);
                        $inputId = 'quantity_' . h($item->deliveryItem_id);
                        $selectId = 'select_' . h($item->deliveryItem_id);
                        ?>
                        <div style="display: flex; gap: 8px; align-items: center;">
                            <select name="quantities[<?= h($item->deliveryItem_id) ?>]" id="<?= $selectId ?>" style="width: 70px;">
                                <?php for ($i = 0; $i <= $max; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                            <input type="number" min="0" max="<?= $max ?>" step="1" id="<?= $inputId ?>" style="width: 70px;" value="0">
                        </div>
                        <script>
                        (function() {
                            var select = document.getElementById('<?= $selectId ?>');
                            var input = document.getElementById('<?= $inputId ?>');
                            // select → input
                            select.addEventListener('change', function() {
                                input.value = select.value;
                            });
                            // input → select
                            input.addEventListener('input', function() {
                                var val = parseInt(input.value, 10);
                                if (isNaN(val) || val < 0) val = 0;
                                if (val > <?= $max ?>) val = <?= $max ?>;
                                input.value = val;
                                select.value = val;
                            });
                        })();
                        </script>
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
