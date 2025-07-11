
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>顧客一覧</title>
    <style>
        body {
            background: #f8f9fa;
            margin: 0;
            padding: 0;;
            font-family: 'MS UI Gothic', Arial, sans-serif;
            overflow-x: hidden;
        }
        .container {
            width: 100vw;
            margin: 0;
            padding: 40px 0 32px 0;
            background: #fff;
            border-radius: 0;
            box-shadow: none;
            box-sizing: border-box;
        }
        .button-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-top: 24px;
        }
        .action-button {
            background-color: #1976d2;
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0 40px;
            font-size: 20px;
            height: 44px;
            display: inline-block;
            text-align: center;
            line-height: 44px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
        }
        .action-button:hover {
            background: #1565c0;
        }
        .title {
            font-size: 48px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 32px;
            letter-spacing: 4px;
        }
        .search-form {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 32px;
        }
        .search-input {
            width: 260px;
            height: 40px;
            font-size: 18px;
            padding: 0 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-button {
            width: 90px;
            height: 40px;
            background: #e53935;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
        }
        .search-button:hover {
            background: #b71c1c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
            background: #fff;
        }
        th, td {
            border: 1px solid #e0e0e0;
            padding: 12px 8px;
            text-align: left;
            font-size: 18px;
        }
        th {
            background: #f5f5f5;
            font-weight: bold;
        }
        tr:hover {
            background: #f1f8ff;
        }
        .select-link {
            color: #1976d2;
            text-decoration: underline;
            cursor: pointer;
        }
        .back-button {
            display: block;
            width: 120px;
            height: 44px;
            margin: 0 auto;
            background: #e53935;
            color: #fff;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            text-align: center;
            line-height: 44px;
            text-decoration: none;
        }
        .back-button:hover {
            background: #b71c1c;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">顧客一覧</div>
        <form class="search-form" method="get">
            <input type="text" name="keyword" class="search-input" placeholder="顧客名で検索" value="<?= h($this->request->getQuery('keyword') ?? '') ?>">
            <button type="submit" class="search-button">検索</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>顧客ID</th>
                    <th>顧客名</th>
                    <th>電話番号</th>
                    <th>担当者名</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($customers)): ?>
                    <?php foreach ($customers as $customer): ?>
                        <tr>
                            <td><?= h($customer->customer_id) ?></td>
                            <td><?= h($customer->name) ?></td>
                            <td><?= h($customer->phone_number) ?></td>
                            <td><?= h($customer->contact_person) ?></td>
                            <td><a href="#" class="select-link">選択</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="button-section">
            <?= $this->Html->link('戻る', ['controller' => 'Home', 'action' => 'index'], ['class' => 'action-button']) ?>
            <?= $this->Html->link('顧客登録', ['controller' => 'Customers', 'action' => 'add'], ['class' => 'action-button']) ?>
        </div>
    </div>
</body>
</html>