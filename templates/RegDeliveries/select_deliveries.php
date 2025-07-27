<?php
// templates/RegDeliveries/select_deliveries.php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $deliveryItems
 * @var int $customerId
 */
?>
<div class="container">
    <div class="delivery-fullscreen">
        <?= $this->Form->create(null, ['url' => ['action' => 'registerDeliveries']]) ?>
        <div class="delivery-box">
            <input type="hidden" name="customer_id" value="<?= h($customerId) ?>">
            <div class="delivery-header" style="display:flex; align-items:center; justify-content:space-between;">
                <span>納品内容選択</span>
                <div style="display:flex; align-items:center; gap:8px;">
                    <label for="delivery_date" style="font-size:16px;">納品日</label>
                    <input type="date" name="delivery_date" id="delivery_date" value="<?= h(date('Y-m-d')) ?>" style="width:160px; font-size:16px; margin:0;" required>
                </div>
            </div>
            
            <div class="table-container">
                <?php if (empty($deliveryItems) || count($deliveryItems) === 0): ?>
                    <div class="no-data-message">
                        <p>未納品の商品はありません</p>
                    </div>
                <?php else: ?>
                <table class="delivery-table">
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
                                <div class="quantity-controls">
                                    <select name="quantities[<?= h($item->deliveryItem_id) ?>]" id="<?= $selectId ?>" class="quantity-select">
                                        <?php for ($i = 0; $i <= $max; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <input type="number" min="0" max="<?= $max ?>" step="1" id="<?= $inputId ?>" class="quantity-input" value="0">
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
                <?php endif; ?>
            </div>
            
            <div class="delivery-btn-row" style="display:flex; align-items:center; justify-content:space-between; gap:16px;">
                <div class="delivery-btn-left">
                    <?= $this->Html->link('戻る', ['controller' => 'RegDeliveries', 'action' => 'selectCustomer'], ['class' => 'button btn-gray']) ?>
                </div>
                <div style="display:flex; align-items:center; gap:16px; flex:1; justify-content:flex-end;">
                    <?php if (!empty($deliveryItems) && count($deliveryItems) > 0): ?>
                        <button type="submit" class="button btn-blue delivery-btn-right">登録</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?= $this->Form->end() ?>
    </div>
</div>

<?php $flashMsg = $this->Flash->render(); ?>
<script>
// Flashメッセージ表示
<?php if (!empty($flashMsg)): ?>
    window.onload = function() {
        alert('<?= strip_tags(trim($flashMsg)) ?>');
    };
<?php endif; ?>
</script>

<style>
html, body {
    width: 100vw;
    min-height: 100vh;
    margin: 0;
    padding: 0;
    background: #fff;
}

.container {
    width: 100vw;
    min-height: 100vh;
    margin: 0;
    background: #fff;
    display: block;
    position: relative;
}

.delivery-fullscreen {
    width: 100vw;
    min-height: 100vh;
    margin: 0;
    display: block;
    background: transparent;
    position: absolute;
    top: 0;
    left: 0;
}

.delivery-box {
    border: 2px solid #222;
    padding: 24px 16px 16px 16px;
    background: #fff;
    width: 950px;
    max-width: 95vw;
    min-height: auto;
    box-sizing: border-box;
    margin: 32px auto;
    border-radius: 0;
    overflow-x: auto;
}

.delivery-header {
    font-size: 18px;
    margin-bottom: 12px;
    flex-wrap: wrap;
}

.table-container {
    width: 100%;
    overflow-x: auto;
    margin-bottom: 12px;
}

.delivery-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 12px;
    table-layout: fixed;
    word-break: break-all;
}

.delivery-table th, .delivery-table td {
    font-size: 16px;
    padding: 8px 8px;
    border: 1px solid #222;
    text-align: center;
    background: #fff;
    word-break: break-word;
}

.delivery-table th {
    background: #fff;
    font-weight: bold;
}

.quantity-controls {
    display: flex;
    gap: 8px;
    align-items: center;
    justify-content: center;
}

.quantity-select, .quantity-input {
    width: 70px;
    padding: 2px 4px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.no-data-message {
    text-align: center;
    padding: 40px 20px;
}

.no-data-message p {
    color: #e53935;
    font-size: 16px;
    font-weight: bold;
    margin: 0;
}

.delivery-btn-row {
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    align-items: center;
    margin-top: 24px;
    gap: 12px;
    width: 100%;
}

.delivery-btn-left, .delivery-btn-right {
    width: 140px;
    min-width: 80px;
    flex-shrink: 1;
}

.button {
    width: 100%;
    font-size: 18px;
    padding: 0;
    border-radius: 6px;
    height: 40px;
    line-height: 40px;
    border: 1px solid #222;
    background: #fff;
    color: #222;
    font-weight: bold;
    cursor: pointer;
    margin: 0 8px;
    box-sizing: border-box;
    transition: background 0.2s;
    text-align: center;
    vertical-align: middle;
    display: inline-block;
    text-decoration: none;
}

.button:hover {
    background: #e0e0e0;
}

.btn-gray {
    background: #6c757d;
    color: #fff;
    border: 1px solid #6c757d;
}

.btn-gray:hover {
    background: #5a6268;
    color: #fff;
    text-decoration: none;
}

.btn-blue {
    background: #1976d2;
    color: #fff;
    border: 1px solid #1976d2;
}

.btn-blue:hover {
    background: #1565c0;
    color: #fff;
}

/* スピンボタン非表示 */
input[type=number]::-webkit-outer-spin-button,
input[type=number]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance: textfield;
}

/* レスポンシブ対応 */
@media (max-width: 1100px) {
    .delivery-box {
        width: 99vw;
        min-width: 0;
        padding: 12px 2vw 12px 2vw;
    }
    .delivery-table th, .delivery-table td {
        font-size: 15px;
        padding: 6px 4px;
    }
    .delivery-header {
        font-size: 16px;
    }
    .button {
        font-size: 16px;
        height: 38px;
        line-height: 38px;
    }
    .quantity-select, .quantity-input {
        width: 60px;
        font-size: 13px;
    }
}

@media (max-width: 700px) {
    .delivery-box {
        width: 100vw;
        min-width: 0;
        margin: 0;
        border-width: 1px;
        padding: 6vw 0 6vw 0;
        border-radius: 0;
    }
    .delivery-header {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 8px;
        font-size: 15px;
    }
    .delivery-table th, .delivery-table td {
        font-size: 14px;
        padding: 4px 2px;
    }
    .delivery-btn-row {
        flex-direction: row !important;
        align-items: center !important;
        gap: 8px;
    }
    .delivery-btn-left, .delivery-btn-right {
        width: 100px;
        min-width: 60px;
        flex-shrink: 1;
    }
    .button {
        font-size: 15px;
        height: 36px;
        line-height: 36px;
        margin: 0 0 8px 0;
    }
    .quantity-controls {
        flex-direction: column;
        gap: 4px;
    }
    .quantity-select, .quantity-input {
        width: 50px;
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .delivery-box {
        padding: 2vw 0 2vw 0;
    }
    .delivery-header {
        font-size: 14px;
    }
    .delivery-table th, .delivery-table td {
        font-size: 13px;
        padding: 2px 1px;
    }
    .button {
        font-size: 13px;
        height: 32px;
        line-height: 32px;
    }
    .quantity-select, .quantity-input {
        width: 45px;
        font-size: 11px;
    }
    .delivery-header div {
        width: 100%;
        justify-content: space-between;
    }
    .delivery-header input[type="date"] {
        width: 140px !important;
        font-size: 14px !important;
    }
}
</style>