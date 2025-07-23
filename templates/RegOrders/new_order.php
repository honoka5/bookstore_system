<div class="container">
  <div class="order-fullscreen">
    <form method="post" accept-charset="utf-8" action="<?= $this->Url->build(["controller" => "RegOrders", "action" => "newOrder", $customerId]) ?>">
      <div class="order-box">
        <div class="order-header">
          <span>注文書</span>
          <span style="margin-left:32px;"> <?= h($customer->name ?? '') ?> 様</span>
          <span class="order-date"> <?= date('Y年n月j日') ?> </span>
        </div>
        <table class="order-table">
          <tr>
            <th>書籍名</th>
            <th>数量</th>
            <th>単価</th>
            <th>摘要</th>
          </tr>
<?php
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$itemsPerPage = 5;
$totalItems = 15;
$start = ($page - 1) * $itemsPerPage;
$end = min($start + $itemsPerPage, $totalItems);
for ($i = $start; $i < $end; $i++): ?>
<tr>
  <td><?= $this->Form->control("order_items.{$i}.book_title", ['label' => false, 'style'=>'width:100%;']) ?></td>
  <td><?= $this->Form->control("order_items.{$i}.book_amount", ['label' => false, 'type' => 'number', 'min' => 1, 'max' => 999, 'inputmode' => 'numeric', 'style'=>'width:100%;']) ?></td>
  <td><?= $this->Form->control("order_items.{$i}.unit_price", ['label' => false, 'type' => 'number', 'min' => 1, 'max' => 9999999, 'inputmode' => 'numeric', 'style'=>'width:100%;']) ?></td>
  <td><?= $this->Form->control("order_items.{$i}.book_summary", ['label' => false, 'style'=>'width:100%;']) ?></td>
</tr>
<?php endfor; ?>
          <tr>
            <td colspan="4" style="padding-top:12px;">
              <?= $this->Form->control("orders.remark", ['label' => '備考', 'style'=>'width:100%; min-width:800px;']) ?>
            </td>
          </tr>
        </table>
        <div class="order-btn-row">
          <div class="order-btn-left">
            <?= $this->Html->link('戻る', ['controller' => 'RegOrders', 'action' => 'selectCustomer'], ['class' => 'button']) ?>
          </div>
          <div style="display:flex; align-items:center; gap:16px; justify-content:center; width:100%;">
            <div class="pagination" style="display:flex; gap:8px; justify-content:center; width:100%;">
              <?php
                $totalPages = ceil($totalItems / $itemsPerPage);
                for ($p = 1; $p <= $totalPages; $p++):
              ?>
                <a href="?page=<?= $p ?>" class="button" style="width:40px; text-align:center; padding:0;<?= ($page == $p) ? 'background:#1976d2;color:#fff;' : '' ?>">
                  <?= $p ?>
                </a>
              <?php endfor; ?>
            </div>
            <button type="submit" class="button order-btn-left">作成</button>
          </div>
        </div>
      </div>
    </form>
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

// --- 入力値のlocalStorage保存・復元 ---
const formKey = 'newOrderFormData';
function saveFormToStorage() {
  const data = {};
  document.querySelectorAll('[name^="order_items"]').forEach(el => {
    data[el.name] = el.value;
  });
  const remark = document.querySelector('[name="orders[remark]"]');
  if (remark) data['orders[remark]'] = remark.value;
  localStorage.setItem(formKey, JSON.stringify(data));
}
function loadFormFromStorage() {
  const data = JSON.parse(localStorage.getItem(formKey) || '{}');
  Object.keys(data).forEach(name => {
    const el = document.querySelector(`[name='${name}']`);
    if (el) el.value = data[name];
  });
}
function clearFormStorage() {
  localStorage.removeItem(formKey);
}
window.addEventListener('DOMContentLoaded', loadFormFromStorage);
document.querySelectorAll('[name^="order_items"], [name="orders[remark]"]').forEach(el => {
  el.addEventListener('input', saveFormToStorage);
});
document.querySelector('form').addEventListener('submit', clearFormStorage);
</script>

<style>
  .container {
    width: 100vw;
    min-height: 100vh;
    margin: 0;
    background: #fff;
    display: block;
    position: relative;
  }
  .order-fullscreen {
    width: 100vw;
    min-height: 100vh;
    margin: 0;
    display: block;
    background: transparent;
    position: absolute;
    top: 0;
    left: 0;
  }
  .order-box {
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
  .order-header {
    font-size: 18px;
    margin-bottom: 12px;
  }
  .order-date {
    margin-left: auto;
    font-size: 16px;
  }
  .order-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 12px;
  }
  .order-table th, .order-table td {
    font-size: 16px;
    padding: 8px 8px;
    border: 1px solid #222;
    text-align: left;
    background: #fff;
  }
  .order-table th {
    background: #fff;
    font-weight: bold;
    text-align: center;
  }
  .order-btn-row {
    display: flex;
    justify-content: space-between;
    margin-top: 24px;
  }
  .order-btn-left, .order-btn-right {
    width: 160px;
  }
  .button {
    width: 100%;
    font-size: 18px;
    padding: 8px 0;
    border-radius: 6px;
    height: 40px;
    border: 1px solid #222;
    background: #fff;
    color: #222;
    font-weight: bold;
    cursor: pointer;
    margin: 0 8px;
    box-sizing: border-box;
    transition: background 0.2s;
  }
  /* .create-btn 削除（作成ボタンはbuttonクラスのみで統一） */
  .button:hover {
    background: #e0e0e0;
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
</style>