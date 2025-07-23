
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MBS - 統計情報確認</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background-color: #f5f5f5;
            min-height: 100vh;
        }

        .main-content {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            min-height: calc(100vh - 60px);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .filter-form {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 4px;
        }

        .filter-form label {
            font-weight: bold;
            margin-right: 10px;
        }

        .filter-form select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 10px;
        }

        .filter-form button {
            padding: 8px 16px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .filter-form button:hover {
            background: #218838;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: white;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }

        table tbody tr:hover {
            background: #f8f9fa;
        }

        .back-button {
            margin-top: 32px;
        }

        .back-button a {
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 10px 20px;
            font-size: 14px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: background 0.2s;
        }

        .back-button a:hover {
            background-color: #5a6268;
        }

        .no-data {
            text-align: center;
            color: #6c757d;
            padding: 40px;
            background: #f8f9fa;
            border-radius: 4px;
            margin: 20px 0;
        }

        .error-message {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 12px;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <!-- 共通ヘッダーを読み込み -->
    <?= $this->element('common_header') ?>

    <div class="main-content">
        <h1>統計情報確認</h1>
        
        <!-- エラーメッセージ表示 -->
        <?php if ($this->Flash->render()): ?>
            <div class="error-message">
                <?= $this->Flash->render() ?>
            </div>
        <?php endif; ?>
        
        <div class="filter-form">
            <form method="get">
                <label for="bookstore_name">書店名:</label>
                <select name="bookstore_name" id="bookstore_name">
                    <option value="">全店舗</option>
                    <?php if (isset($bookstoreNames) && count($bookstoreNames) > 0): ?>
                        <?php foreach ($bookstoreNames as $name): ?>
                            <option value="<?= h($name->bookstore_name) ?>" <?= ($selectedBookstore ?? '') === $name->bookstore_name ? 'selected' : '' ?>>
                                <?= h($name->bookstore_name) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <button type="submit">表示</button>
            </form>
        </div>

        <?php if (isset($customers) && count($customers) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>顧客ID</th>
                        <th>顧客名</th>
                        <th>累計売上金額</th>
                        <th>平均リードタイム</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <?php
                        try {
                            $stat = \Cake\ORM\TableRegistry::getTableLocator()->get('Statistics')
                                ->find()
                                ->where(['customer_id' => $customer->customer_id])
                                ->order(['calc_date' => 'DESC'])
                                ->first();
                        } catch (\Exception $e) {
                            $stat = null;
                        }
                        ?>
                        <tr>
                            <td><?= h($customer->customer_id) ?></td>
                            <td><?= h($customer->name ?? '') ?></td>
                            <td><?= $stat ? number_format($stat->total_purchase_amt) . '円' : '未計算' ?></td>
                            <td><?= $stat ? $stat->avg_lead_time . '日' : '未計算' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="no-data">
                <h3>データがありません</h3>
                <p>統計情報を表示する顧客データが見つかりませんでした。</p>
                <p>注文書を作成すると、こちらに表示されます。</p>
            </div>
        <?php endif; ?>

        <div class="back-button">
            <?= $this->Html->link('戻る', ['controller' => 'Home', 'action' => 'index']) ?>
        </div>
    </div>
</body>
</html>