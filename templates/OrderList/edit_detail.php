<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文書詳細（編集）</title>
    <style>
        body { 
            font-family: "MS UI Gothic", sans-serif; 
            background-color: #f0f0f0; 
            margin: 0; 
            padding: 0; 
        }
        .main-container { 
            max-width: 700px; 
            margin: 32px auto; 
            background: #fff; 
            border-radius: 8px; 
            box-shadow: 0 2px 8px #0001; 
            padding: 32px; 
        }
        h2 { 
            margin-top: 0; 
            color: #000000; 
        }
        .info-list p { 
            margin: 6px 0; 
            font-size: 15px; 
            color: #000000; 
        }
        table { 
            border-collapse: collapse; 
            width: 100%; 
            margin-top: 18px; 
        }
        th, td { 
            border: 1px solid #888; 
            padding: 6px 10px; 
            font-size: 14px; 
            text-align: center; 
        }
        th { 
            background: #e3f2fd; 
            font-weight: bold; 
            color: #000000; 
        }
        tfoot td { 
            background: #f9f9f9; 
            font-weight: bold; 
        }
        .button-area-left { 
            position: fixed; 
            left: 30px; 
            bottom: 30px; 
            z-index: 100; 
        }
        .button-area-right { 
            position: fixed; 
            right: 30px; 
            bottom: 30px; 
            z-index: 100; 
        }
        .button, .btn, .action-btn { 
            background-color: #6c757d; 
            color: #fff; 
            border: none; 
            border-radius: 4px; 
            padding: 8px 32px; 
            font-size: 15px; 
            cursor: pointer; 
            transition: background 0.2s; 
            text-decoration: none; 
            display: inline-block; 
        }
        .button:hover, .btn:hover { 
            background-color: #5a6268; 
        }
        .action-btn {
            background-color: #1976d2;
        }
        .action-btn:hover { 
            background-color: #1565c0; 
        }
        .delete-btn { 
            background: #e53935; 
            color: #fff; 
            border-radius: 4px; 
            padding: 2px 10px; 
            font-size: 15px; 
            cursor: pointer; 
        }
        .delete-btn:active { 
            background: #b71c1c; 
        }
    </style>
</head>
<body>
    <div class="main-container">
        <h2>注文書詳細（編集）</h2>
        <div class="info-list">
            <p>注文書ID: <?= h($order->order_id) ?></p>
            <p>顧客ID: <?= h($order->customer_id) ?></p>
            <p>顧客名: <?= h($order->customer->name ?? '') ?></p>
            <p>注文日: <?= h($order->order_date) ?></p>
        </div>
        <?= $this->Form->create(null, ['type' => 'post', 'id' => 'main-edit-form']) ?>
        <?= $this->Form->end() ?>
        <table>
            <thead>
                <tr>
                    <th>書籍名</th>
                    <th>数量</th>
                    <th>単価</th>
                    <th>摘要</th>
                    <th>削除</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order->order_items as $item): ?>
                <tr>
                    <td><?= $this->Form->text("book_title[{$item->orderItem_id}]", [
                        'value' => $item->book_title,
                        'style' => 'width:140px;',
                        'required' => true,
                        'placeholder' => '書籍名',
                        'form' => 'main-edit-form',
                        'id' => 'book_title_' . $item->orderItem_id
                    ]) ?></td>
                    <td>
                        <?= $this->Form->select("book_amount[{$item->orderItem_id}]", $amountRanges[$item->orderItem_id], [
                            'value' => $item->book_amount,
                            'empty' => false,
                            'style' => 'width:60px;',
                            'form' => 'main-edit-form',
                            'id' => 'amount_select_' . $item->orderItem_id
                        ]) ?>
                        <?= $this->Form->text("book_amount[{$item->orderItem_id}]", [
                            'value' => $item->book_amount,
                            'style' => 'width:50px;',
                            'pattern' => '[0-9]*',
                            'inputmode' => 'numeric',
                            'title' => '数量を直接入力できます',
                            'form' => 'main-edit-form',
                            'id' => 'amount_input_' . $item->orderItem_id
                        ]) ?>
                    </td>
                    <td><?= $this->Form->text("unit_price[{$item->orderItem_id}]", [
                        'value' => $item->unit_price,
                        'style' => 'width:70px;',
                        'form' => 'main-edit-form',
                        'id' => 'unit_price_' . $item->orderItem_id
                    ]) ?></td>
                    <td><?= $this->Form->text("book_summary[{$item->orderItem_id}]", [
                        'value' => $item->book_summary,
                        'style' => 'width:120px;',
                        'form' => 'main-edit-form',
                        'id' => 'book_summary_' . $item->orderItem_id
                    ]) ?></td>
                    <td>
                        <form method="post" action="<?= $this->Url->build(['controller'=>'OrderList','action'=>'deleteOrderItem', $item->orderItem_id]) ?>" style="display:inline;">
                            <input type="hidden" name="_csrfToken" value="<?= h($this->request->getAttribute('csrfToken')) ?>">
                            <button type="submit" class="delete-btn" title="削除" onclick="return confirm('本当に削除しますか？');">&#10005;</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="margin-top:18px;">
            備考: <?= $this->Form->control('remark', ['type'=>'text', 'value'=>$order->remark, 'label'=>false, 'style'=>'width:300px;','form'=>'main-edit-form']) ?>
        </div>
    </div>
    <!-- 戻るボタン（左下） -->
    <div class="button-area-left">
        <?= $this->Html->link('戻る', ['controller' => 'OrderList', 'action' => 'orderDetail', $order->order_id], ['class' => 'button']) ?>
    </div>
    <!-- 確定ボタン（右下） -->
    <div class="button-area-right">
        <button type="submit" form="main-edit-form" class="action-btn">確定</button>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php foreach ($order->order_items as $item): ?>
        (function() {
            var select = document.getElementById('amount_select_<?= $item->orderItem_id ?>');
            var input = document.getElementById('amount_input_<?= $item->orderItem_id ?>');
            if (select && input) {
                select.addEventListener('change', function() {
                    input.value = select.value;
                });
                input.addEventListener('input', function() {
                    select.value = input.value;
                });
            }
        })();
        <?php endforeach; ?>
    });
    </script>
</body>
</html>
