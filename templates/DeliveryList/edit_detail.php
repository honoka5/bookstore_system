<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>納品書詳細（編集）</title>
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
        .button, .action-btn { 
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
        .button:hover { 
            background-color: #5a6268; 
        }
        .action-btn {
            background-color: #1976d2;
        }
        .action-btn:hover { 
            background-color: #1565c0; 
        }
        .action-btn:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .action-btn:disabled:hover {
            background-color: #cccccc;
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
        .change-indicator {
            color: #e53935;
            font-weight: bold;
            margin-left: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <?= $this->element('common_header') ?>

    <div class="main-container">
        <h2>納品書詳細（編集）<span id="change-indicator" class="change-indicator">（変更あり）</span></h2>
        <div class="info-list">
            <p>納品書ID: <?= h($delivery->delivery_id) ?></p>
            <p>顧客ID: <?= h($delivery->customer_id) ?></p>
            <p>顧客名: <?= h($delivery->customer->name ?? '') ?> 様</p>
            <p>納品日: <?php
                // 納品日を「2025年7月12日」形式で表示
                if (isset($delivery->delivery_date) && $delivery->delivery_date) {
                    $date = $delivery->delivery_date;
                    if (is_string($date)) {
                        $dateObj = new DateTime($date);
                    } else {
                        $dateObj = $date;
                    }
                    echo h($dateObj->format('Y年n月j日'));
                }
            ?></p>
        </div>
        
        <form id="main-edit-form" method="post" action="<?= $this->Url->build(['controller'=>'delivery-list','action'=>'editDetail', $delivery->delivery_id]) ?>">
            <input type="hidden" name="_csrfToken" value="<?= h($this->request->getAttribute('csrfToken')) ?>">
        </form>
        
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
                    <td><?= $this->Form->text("book_title[{$item->deliveryItem_id}]", [
                        'value' => $item->book_title,
                        'style' => 'width:120px;',
                        'form' => 'main-edit-form',
                        'id' => 'book_title_' . $item->deliveryItem_id,
                        'data-original' => $item->book_title
                    ]) ?></td>
                    <td>
                        <?php
                        $max = (int)$item->book_amount;
                        $amountOptions = array_combine(range(1, $max), range(1, $max));
                        ?>
                        <?= $this->Form->select("book_amount[{$item->deliveryItem_id}]", $amountOptions, [
                            'value' => $item->book_amount,
                            'empty' => false,
                            'style' => 'width:60px;',
                            'form' => 'main-edit-form',
                            'id' => 'amount_select_' . $item->deliveryItem_id,
                            'data-original' => $item->book_amount
                        ]) ?>
                        <?= $this->Form->text("book_amount[{$item->deliveryItem_id}]", [
                            'value' => $item->book_amount,
                            'style' => 'width:50px;',
                            'pattern' => '[0-9]*',
                            'inputmode' => 'numeric',
                            'title' => '数量を直接入力できます',
                            'form' => 'main-edit-form',
                            'id' => 'amount_input_' . $item->deliveryItem_id,
                            'data-original' => $item->book_amount
                        ]) ?>
                    </td>
                    <td><?= $this->Form->text("unit_price[{$item->deliveryItem_id}]", [
                        'value' => $item->unit_price,
                        'style' => 'width:70px;',
                        'form' => 'main-edit-form',
                        'id' => 'unit_price_' . $item->deliveryItem_id,
                        'data-original' => $item->unit_price
                    ]) ?></td>
                    <td>
                        <form method="post" action="<?= $this->Url->build(['controller'=>'DeliveryList','action'=>'deleteDeliveryItem', $item->deliveryItem_id, $delivery->delivery_id]) ?>" style="display:inline;">
                            <input type="hidden" name="_csrfToken" value="<?= h($this->request->getAttribute('csrfToken')) ?>">
                            <button type="submit" class="delete-btn" style="font-size:18px;" onclick="return confirm('本当に削除しますか？');">&#10005;</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- 戻るボタン（左下） -->
    <div class="button-area-left">
        <?= $this->Html->link('戻る', ['controller' => 'List', 'action' => 'deliveryDetail', $delivery->delivery_id], ['class' => 'button']) ?>
    </div>

    <!-- 確定ボタン（右下） -->
    <div class="button-area-right">
        <button type="submit" form="main-edit-form" class="action-btn" id="submit-btn" disabled>確定</button>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var submitBtn = document.getElementById('submit-btn');
        var changeIndicator = document.getElementById('change-indicator');
        var hasChanges = false;

        // 初期状態では確定ボタンを無効化
        submitBtn.disabled = true;

        // 変更状態を更新する関数
        function updateChangeStatus() {
            var currentHasChanges = false;
            
            // すべてのフォーム要素をチェック
            var formElements = document.querySelectorAll('input[data-original], select[data-original]');
            formElements.forEach(function(element) {
                var original = element.getAttribute('data-original') || '';
                var current = element.value || '';
                
                if (original !== current) {
                    currentHasChanges = true;
                }
            });

            hasChanges = currentHasChanges;
            submitBtn.disabled = !hasChanges;
            
            if (hasChanges) {
                changeIndicator.style.display = 'inline';
                submitBtn.style.backgroundColor = '#1976d2';
                submitBtn.style.cursor = 'pointer';
            } else {
                changeIndicator.style.display = 'none';
                submitBtn.style.backgroundColor = '#cccccc';
                submitBtn.style.cursor = 'not-allowed';
            }
        }

        // 数量のセレクトボックスと入力フィールドの連携
        <?php foreach ($delivery->delivery_items ?? [] as $item): ?>
        (function() {
            var select = document.getElementById('amount_select_<?= $item->deliveryItem_id ?>');
            var input = document.getElementById('amount_input_<?= $item->deliveryItem_id ?>');
            if (select && input) {
                select.addEventListener('change', function() {
                    input.value = select.value;
                    updateChangeStatus();
                });
                input.addEventListener('input', function() {
                    select.value = input.value;
                    updateChangeStatus();
                });
            }
        })();
        <?php endforeach; ?>

        // 全てのフォーム要素に変更監視を追加
        var allFormElements = document.querySelectorAll('input[data-original], select[data-original]');
        allFormElements.forEach(function(element) {
            element.addEventListener('input', updateChangeStatus);
            element.addEventListener('change', updateChangeStatus);
        });

        // フォーム送信時の確認
        document.getElementById('main-edit-form').addEventListener('submit', function(e) {
            if (!hasChanges) {
                e.preventDefault();
                alert('変更がありません。何か編集してから確定ボタンを押してください。');
                return false;
            }
            
            return confirm('変更内容を保存しますか？');
        });

        // 初期状態をチェック
        updateChangeStatus();
    });
    </script>
</body>
</html>