<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>注文書詳細（編集）</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-family: "MS UI Gothic", sans-serif;
            background-color: #f8f9fa;
        }
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
            padding: 32px;
        }
        .header-section {
            background: #ff9800;
            color: #fff;
            padding: 18px 24px;
            border-radius: 6px;
            margin-bottom: 24px;
        }
        .header-section h2 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }
        .info-section {
            background: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 24px;
            margin-bottom: 24px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 18px;
        }
        .info-table th, .info-table td {
            border: 1px solid #e0e0e0;
            padding: 12px 16px;
            text-align: left;
        }
        .info-table th {
            background: #f5f5f5;
            font-weight: bold;
            width: 200px;
        }
        .details-section {
            margin-bottom: 24px;
        }
        .details-section h3 {
            background: #4caf50;
            color: #fff;
            padding: 12px 24px;
            border-radius: 6px;
            margin: 0 0 16px 0;
            font-size: 20px;
            font-weight: bold;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 16px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            overflow: hidden;
        }
        .details-table th, .details-table td {
            border: 1px solid #e0e0e0;
            padding: 14px 12px;
            text-align: left;
        }
        .details-table th {
            background: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }
        .details-table td {
            background: #fff;
        }
        .details-table tr:nth-child(even) td {
            background: #f9f9f9;
        }
        .form-input {
            border: 1px solid #ddd;
            padding: 8px;
            border-radius: 4px;
            font-size: 14px;
        }
        .form-select {
            border: 1px solid #ddd;
            padding: 8px;
            border-radius: 4px;
            font-size: 14px;
            background: white;
        }
        .button-section {
            position: fixed;
            right: 30px;
            bottom: 30px;
            display: flex;
            gap: 12px;
            z-index: 100;
        }
        .button {
            background-color: #1976d2;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 12px 24px;
            font-size: 16px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }
        .button:hover {
            background: #1565c0;
            color: #fff;
        }
        .button-back {
            background-color: #666;
        }
        .button-back:hover {
            background: #444;
        }
        .button-save {
            background-color: #4caf50;
        }
        .button-save:hover {
            background: #388e3c;
        }
        .delete-btn {
            background: #e53935;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
            cursor: pointer;
        }
        .delete-btn:hover {
            background: #b71c1c;
        }
        @media screen and (max-width: 768px) {
            .main-container {
                padding: 16px;
                margin: 0 8px;
            }
            .button-section {
                position: static;
                justify-content: center;
                margin-top: 24px;
                flex-wrap: wrap;
            }
            .info-table, .details-table {
                font-size: 14px;
            }
            .info-table th {
                width: 120px;
            }
            .form-input, .form-select {
                font-size: 12px;
                padding: 6px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header Section -->
        <div class="header-section">
            <h2>注文書詳細（編集）</h2>
        </div>

        <!-- Order Information Section -->
        <?= $this->Form->create(null, ['type' => 'post', 'id' => 'main-edit-form']) ?>
        <div class="info-section">
            <table class="info-table">
                <tr>
                    <th>注文書ID</th>
                    <td><?= h($order->order_id) ?></td>
                </tr>
                <tr>
                    <th>顧客ID</th>
                    <td><?= h($order->customer_id) ?></td>
                </tr>
                <tr>
                    <th>顧客名</th>
                    <td><?= h($order->customer->name ?? '') ?></td>
                </tr>
                <tr>
                    <th>注文日</th>
                    <td><?= h($order->order_date) ?></td>
                </tr>
                <tr>
                    <th>備考</th>
                    <td><?= $this->Form->control('remark', ['type'=>'text', 'value'=>$order->remark, 'label'=>false, 'class'=>'form-input', 'style'=>'width:300px;']) ?></td>
                </tr>
            </table>
        </div>
        <?= $this->Form->end() ?>

        <!-- Order Details Section -->
        <div class="details-section">
            <h3>注文内容（明細）</h3>
            <table class="details-table">
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
                            'class' => 'form-input',
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
                                'class' => 'form-select',
                                'style' => 'width:60px;',
                                'form' => 'main-edit-form',
                                'id' => 'amount_select_' . $item->orderItem_id
                            ]) ?>
                            <?= $this->Form->text("book_amount[{$item->orderItem_id}]", [
                                'value' => $item->book_amount,
                                'class' => 'form-input',
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
                            'class' => 'form-input',
                            'style' => 'width:70px;',
                            'form' => 'main-edit-form',
                            'id' => 'unit_price_' . $item->orderItem_id
                        ]) ?></td>
                        <td><?= $this->Form->text("book_summary[{$item->orderItem_id}]", [
                            'value' => $item->book_summary,
                            'class' => 'form-input',
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
        </div>

        <!-- Action Buttons Section -->
        <div class="button-section">
            <?= $this->Html->link('戻る', ['controller' => 'OrderList', 'action' => 'orderDetail', $order->order_id], ['class' => 'button button-back']) ?>
            <button type="submit" form="main-edit-form" class="button button-save">確定</button>
        </div>
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
