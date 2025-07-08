<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>納品書詳細（編集）</title>
    <style>
        body { font-family: "MS UI Gothic", sans-serif; background-color: #f0f0f0; margin: 0; padding: 0; }
        .main-container { max-width: 700px; margin: 32px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px #0001; padding: 32px; }
        h2 { margin-top: 0; color: #1976d2; }
        .info-list p { margin: 6px 0; font-size: 15px; }
        table { border-collapse: collapse; width: 100%; margin-top: 18px; }
        th, td { border: 1px solid #888; padding: 6px 10px; font-size: 14px; text-align: center; }
        th { background: #e3f2fd; font-weight: bold; }
        tfoot td { background: #f9f9f9; font-weight: bold; }
        .button-area { margin-top: 24px; display: flex; gap: 24px; justify-content: flex-start; }
        .button, .action-btn { background-color: #1976d2; color: #fff; border: none; border-radius: 4px; padding: 8px 32px; font-size: 15px; cursor: pointer; transition: background 0.2s; text-decoration: none; display: inline-block; }
        .button:hover, .action-btn:hover { background-color: #1565c0; }
        .delete-btn { background: #e53935; color: #fff; border-radius: 4px; padding: 2px 10px; font-size: 15px; cursor: pointer; }
        .delete-btn:active { background: #b71c1c; }
    </style>
</head>
<body>
    <div class="main-container">
        <h2>納品書詳細（編集）</h2>
        <div class="info-list">
            <p>納品書ID: <?= h($delivery->delivery_id) ?></p>
            <p>顧客ID: <?= h($delivery->customer_id) ?></p>
            <p>顧客名: <?= h($delivery->customer->name ?? '') ?> 様</p>
            <p>納品日: <?= h($delivery->delivery_date) ?></p>
        </div>
        <?= $this->Form->create(null, ['type' => 'post', 'url' => ['controller' => 'delivery-list', 'action' => 'editDetail', $delivery->delivery_id]]) ?>
        <table>
            <thead>
                <tr>
                    <th>書籍名</th>
                    <th>数量</th>
                    <th>単価</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($delivery->delivery_items ?? [] as $item): ?>
                <tr>
                    <td><?= $this->Form->text("book_title[{$item->deliveryItem_id}]", ['value' => $item->book_title, 'style' => 'width:120px;']) ?></td>
                    <td><?= $this->Form->text("book_amount[{$item->deliveryItem_id}]", ['value' => $item->book_amount, 'style' => 'width:60px;', 'pattern' => '[0-9]*', 'inputmode' => 'numeric']) ?></td>
                    <td><?= $this->Form->text("unit_price[{$item->deliveryItem_id}]", ['value' => $item->unit_price, 'style' => 'width:70px;']) ?></td>
                    <td>
                        <button type="button" class="delete-btn" onclick="confirmDelete(<?= $item->deliveryItem_id ?>, <?= $delivery->delivery_id ?>)">&#10005;</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <form id="main-edit-form" method="post" action="<?= $this->Url->build(['controller'=>'delivery-list','action'=>'editDetail', $delivery->delivery_id]) ?>">
            <div class="button-area">
                <?= $this->Html->link('戻る', ['controller' => 'List', 'action' => 'deliveryDetail', $delivery->delivery_id], ['class' => 'button']) ?>
                <button type="submit" class="action-btn">保存</button>
            </div>
            <input type="hidden" name="_csrfToken" value="<?= h($this->request->getAttribute('csrfToken')) ?>">
        </form>
    </div>
</body>
</html>
<script>
function confirmDelete(itemId, deliveryId) {
    if (!confirm('本当に削除しますか？')) return;

    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/delivery-list/deleteDeliveryItem/${itemId}/${deliveryId}`;

    const token = document.createElement('input');
    token.type = 'hidden';
    token.name = '_csrfToken';
    token.value = <?= json_encode($this->request->getAttribute('csrfToken')) ?>;

    form.appendChild(token);
    document.body.appendChild(form);
    form.submit();
}
</script>

