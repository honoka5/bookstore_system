<div class="container">
  <div class="order-fullscreen">
    <?= $this->Form->create(null, [
      'url' => ["controller" => "RegOrders", "action" => "newOrder", $customerId],
      'type' => 'post',
      'autocomplete' => 'off',
      'accept-charset' => 'utf-8',
    ]) ?>
      <div class="order-box">
        <?= $this->Form->hidden('customer_id', ['value' => $customerId]) ?>
        <?php if (isset($customerName) && $customerName): ?>
          <?= $this->Form->hidden('customer_name', ['value' => $customerName]) ?>
        <?php endif; ?>
        <div class="order-header" style="display:flex; align-items:center; justify-content:space-between;">
          <span>注文書<?= isset($customerName) && $customerName ? '　　' . h($customerName) . ' 様' : '' ?></span>
          <div style="display:flex; align-items:center; gap:8px;">
            <label for="order-date" style="font-size:16px;">注文日</label>
            <?= $this->Form->control('order_date', [
              'type' => 'date',
              'label' => false,
              'id' => 'order-date',
              'style' => 'width:160px; font-size:16px; margin:0;',
              'value' => isset($data['order_date']) ? $data['order_date'] : date('Y-m-d'),
              'required' => true
            ]) ?>
          </div>
        </div>
        <table class="order-table">
          <tr>
            <th>書籍名<span style="color:#d32f2f;">*</span></th>
            <th>数量<span style="color:#d32f2f;">*</span></th>
            <th>単価<span style="color:#d32f2f;">*</span></th>
            <th>摘要</th>
          </tr>
<?php
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$itemsPerPage = 5;
$totalItems = 15;
for ($i = 0; $i < $totalItems; $i++):
  $rowPage = floor($i / $itemsPerPage) + 1;
?>
<tr class="order-row" data-page="<?= $rowPage ?>" style="display:<?= ($rowPage == $page) ? '' : 'none' ?>;">
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
        <div class="pagination" style="display:flex; gap:8px; justify-content:center; margin: 16px 0 0 0;">
          <?php
            $totalPages = ceil($totalItems / $itemsPerPage);
            for ($p = 1; $p <= $totalPages; $p++):
          ?>
            <a href="?page=<?= $p ?>" class="button page-link" data-page="<?= $p ?>" style="width:40px; text-align:center; padding:0;<?= ($page == $p) ? 'background:#1976d2;color:#fff;' : '' ?>">
              <?= $p ?>
            </a>
          <?php endfor; ?>
        </div>
        <div class="order-btn-row" style="display:flex; align-items:center; justify-content:space-between; gap:16px;">
          <div class="order-btn-left">
            <?= $this->Html->link('戻る', ['controller' => 'RegOrders', 'action' => 'selectCustomer'], ['class' => 'button']) ?>
          </div>
          <div style="display:flex; align-items:center; gap:16px; flex:1; justify-content:flex-end;">
            <button type="submit" class="button order-btn-left">作成</button>
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

// --- 入力値のlocalStorage保存・復元 ---
const formKey = 'newOrderFormData';
function saveFormToStorage() {
  const data = {};
  document.querySelectorAll('[name^="order_items"], [name="orders[remark]"]').forEach(el => {
    data[el.name] = el.value;
  });
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

// ページ切り替え時のtr表示制御
document.querySelectorAll('.page-link').forEach(link => {
  link.addEventListener('click', function(e) {
    e.preventDefault();
    const page = this.getAttribute('data-page');
    document.querySelectorAll('.order-row').forEach(tr => {
      tr.style.display = (tr.getAttribute('data-page') == page) ? '' : 'none';
    });
    // ページリンクの色切り替え
    document.querySelectorAll('.page-link').forEach(l => {
      if (l.getAttribute('data-page') == page) {
        l.style.background = '#1976d2';
        l.style.color = '#fff';
      } else {
        l.style.background = '';
        l.style.color = '';
      }
    });
    // URLの?page=xxxを書き換え（履歴は残さない）
    const url = new URL(window.location.href);
    url.searchParams.set('page', page);
    window.history.replaceState(null, '', url.toString());
  });
});
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
    flex-wrap: wrap;
  }
  .order-date {
    margin-left: auto;
    font-size: 16px;
  }
  .order-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 12px;
    table-layout: fixed;
    word-break: break-all;
  }
  .order-table th, .order-table td {
    font-size: 16px;
    padding: 8px 8px;
    border: 1px solid #222;
    text-align: left;
    background: #fff;
    word-break: break-word;
  }
  .order-table th {
    background: #fff;
    font-weight: bold;
    text-align: center;
  }
  .order-btn-row {
    display: flex;
    flex-wrap: nowrap;
    justify-content: space-between;
    align-items: center;
    margin-top: 24px;
    gap: 12px;
    width: 100%;
  }
  .order-btn-left, .order-btn-right {
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
  }
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

  /* レスポンシブ対応 */
  @media (max-width: 1100px) {
    .order-box {
      width: 99vw;
      min-width: 0;
      padding: 12px 2vw 12px 2vw;
    }
    .order-table th, .order-table td {
      font-size: 15px;
      padding: 6px 4px;
    }
    .order-header {
      font-size: 16px;
    }
    .button {
      font-size: 16px;
      height: 38px;
      line-height: 38px;
    }
  }
  @media (max-width: 700px) {
    .order-box {
      width: 100vw;
      min-width: 0;
      margin: 0;
      border-width: 1px;
      padding: 6vw 0 6vw 0;
      border-radius: 0;
    }
    .order-header {
      flex-direction: column;
      align-items: flex-start !important;
      gap: 8px;
      font-size: 15px;
    }
    .order-table th, .order-table td {
      font-size: 14px;
      padding: 4px 2px;
    }
    .order-btn-row {
      flex-direction: row !important;
      align-items: center !important;
      gap: 8px;
    }
    .order-btn-left, .order-btn-right {
      width: 100px;
      min-width: 60px;
      flex-shrink: 1;
    }
    .pagination {
      flex-wrap: wrap;
      gap: 4px;
    }
    .button {
      font-size: 15px;
      height: 36px;
      line-height: 36px;
      margin: 0 0 8px 0;
    }
    td[colspan="4"] > .form-control {
      min-width: 0 !important;
      width: 100% !important;
    }
  }
  @media (max-width: 480px) {
    .order-box {
      padding: 2vw 0 2vw 0;
    }
    .order-header {
      font-size: 14px;
    }
    .order-table th, .order-table td {
      font-size: 13px;
      padding: 2px 1px;
    }
    .button {
      font-size: 13px;
      height: 32px;
      line-height: 32px;
    }
  }
</style>