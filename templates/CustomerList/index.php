<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>MBS - 顧客一覧</title>
    <style>
        body {
            font-family: 'MS UI Gothic', Arial, sans-serif;
            font-size: 13px;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #e8e8e8;
            border: 2px inset #c0c0c0;
            width: 90vw;
            max-width: 1200px;
            margin: 30px auto;
            padding: 0;
            min-height: 80vh;
            box-sizing: border-box;
        }
        .header {
            background: linear-gradient(to bottom, #d4d4d4, #b8b8b8);
            border-bottom: 1px solid #999;
            display: flex;
            height: 32px;
            line-height: 32px;
        }
        .header-cell {
            border-right: 1px solid #999;
            padding: 0 16px;
            font-weight: bold;
            font-size: 14px;
        }
        .header-cell:last-child {
            border-right: none;
        }
        .content {
            padding: 24px;
            background-color: #fffbe6;
            min-height: 70vh;
        }
        .search-section {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .search-input {
            width: 180px;
            height: 28px;
            border: 1px solid #aaa;
            padding: 2px 8px;
            font-size: 13px;
        }
        .search-button {
            width: 60px;
            height: 32px;
            background: linear-gradient(to bottom, #3a8cff, #0059b3);
            color: #fff;
            border: 1px solid #0059b3;
            font-size: 13px;
            cursor: pointer;
            border-radius: 4px;
        }
        .search-button:active {
            border: 1px inset #c0c0c0;
        }
        .table-container {
            border: 1px solid #c0c0c0;
            background-color: white;
            height: 55vh;
            overflow-y: auto;
            margin-bottom: 24px;
        }
        table.customer-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        table.customer-table th, table.customer-table td {
            border: 1px solid #e0e0e0;
            padding: 8px 6px;
            text-align: left;
        }
        table.customer-table th {
            background: linear-gradient(to bottom, #f0f0f0, #d0d0d0);
            font-weight: bold;
        }
        table.customer-table tr.selected {
            background-color: #316ac5;
            color: white;
        }
        table.customer-table tr:hover {
            background-color: #e6f3ff;
        }
        .button-section {
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
        }
        .action-button {
            width: 110px;
            height: 36px;
            background: linear-gradient(to bottom, #f0f0f0, #d0d0d0);
            border: 1px solid #c0c0c0;
            font-size: 14px;
            cursor: pointer;
            border-radius: 4px;
        }
        .action-button:active {
            border: 1px inset #c0c0c0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-cell">MBS</div>
            <div class="header-cell">顧客一覧</div>
            <div class="header-cell">ホーム＞顧客一覧</div>
        </div>
        <div class="content">
            <div class="search-section">
                <?= $this->Form->create(null, ['type' => 'get', 'style' => 'display:inline']) ?>
                <?= $this->Form->control('keyword', [
                    'label' => false,
                    'placeholder' => '顧客名・電話番号など',
                    'class' => 'search-input',
                    'value' => $this->request->getQuery('keyword') ?? ''
                ]) ?>
                <?= $this->Form->button('検索', ['class' => 'search-button']) ?>
                <?= $this->Form->end() ?>
            </div>
            <div class="table-container">
                <table class="customer-table">
                    <thead>
                        <tr>
                            <th>顧客ID</th>
                            <th>店舗名</th>
                            <th>顧客名</th>
                            <th>担当者名</th>
                            <th>電話番号</th>
                   
                        </tr>
                    </thead>
                    <tbody>



                    <?php if (!empty($customers)): ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?= h($customer->customer_id) ?></td>
                                    <td><?= h($customer->bookstore_name) ?></td>
                                    <td><?= h($customer->name) ?></td>
                                    <td><?= h($customer->contact_person) ?></td>
                                    <td><?= h($customer->phone_number) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="button-section">
                <?= $this->Html->link('戻る', ['controller' => 'Home', 'action' => 'index'], ['class' => 'action-button']) ?>
                <?= $this->Html->link('顧客登録', ['controller' => 'Customers', 'action' => 'add'], ['class' => 'action-button']) ?>
            </div>
        </div>
    </div>
</body>
</html>