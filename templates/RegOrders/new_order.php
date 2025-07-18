<div class="container">
  <div class="order-fullscreen">
    <?= $this->Form->create(null) ?>
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
$itemsPerPage = 6;
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
          <div style="display:flex; align-items:center; gap:16px;">
            <?php if ($page > 1): ?>
              <a href="?page=<?= $page - 1 ?>" class="button" style="width:auto;">&lt; 前へ</a>
            <?php endif; ?>
            <span style="font-size:18px;"> <?= $page ?> / <?= ceil($totalItems / $itemsPerPage) ?> </span>
            <?php if ($end < $totalItems): ?>
              <a href="?page=<?= $page + 1 ?>" class="button" style="width:auto;">次へ &gt;</a>
            <?php endif; ?>
            <?= $this->Form->button('作成', ['class' => 'button']) ?>
          </div>
        </div>
      </div>
    <?= $this->Form->end() ?>
  </div>
</div>

<?php $flashMsg = $this->Flash->render(); ?>
<script>
<?php if (!empty($flashMsg)): ?>
    window.onload = function() {
        alert('<?= strip_tags(trim($flashMsg)) ?>');
    };
<?php endif; ?>
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
    padding: 24px 48px 16px 48px;
    background: #fff;
    width: 100vw;
    min-height: auto;
    box-sizing: border-box;
    margin: 0;
    border-radius: 0;
  }
  .order-header {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    font-size: 18px;
    margin-bottom: 12px;
    font-weight: bold;
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
    border: 1px solid #222;
    padding: 6px 8px;
    text-align: left;
    font-size: 16px;
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
    width: 180px;
  }
  .button {
    width: 100%;
    font-size: 20px;
    padding: 8px 0;
    border-radius: 6px;
    border: 1px solid #222;
    background: #fff;
    color: #222;
    font-weight: bold;
    cursor: pointer;
    margin: 0 8px;
    box-sizing: border-box;
    transition: background 0.2s;
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
</style>