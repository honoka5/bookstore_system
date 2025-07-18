<?php
/**
 * 書店名ごとに顧客情報を一覧表示し、計算ボタンで統計情報を計算する画面
 * @var \App\View\AppView $this
 * @var \Cake\Collection\CollectionInterface $bookstoreNames
 * @var string|null $selectedBookstore
 * @var \Cake\Collection\CollectionInterface $customers
 */
?>
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

        .paging-ui {
            margin-top: 20px;
            text-align: center;
        }

        .paging-ui a {
            color: #28a745;
            text-decoration: none;
            padding: 8px 12px;
            border: 1px solid #28a745;
            border-radius: 4px;
            margin: 0 5px;
            transition: all 0.2s;
        }

        .paging-ui a:hover {
            background: #28a745;
            color: white;
        }

        .paging-ui span {
            padding: 8px 12px;
            margin: 0 5px;
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

        
    </style>
</head>
<body>
    <!-- 共通ヘッダーを読み込み -->
    <?= $this->element('common_header') ?>

    <div class="main-content">
        <h1>統計情報確認</h1>
        
        <div class="filter-form">
            <form method="get">
                <label for="bookstore_name">書店名:</label>
                <select name="bookstore_name" id="bookstore_name">
                    <option value="">全店舗</option>
                    <?php foreach ($bookstoreNames as $name): ?>
                        <option value="<?= h($name->bookstore_name) ?>" <?= $selectedBookstore === $name->bookstore_name ? 'selected' : '' ?>>
                            <?= h($name->bookstore_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">表示</button>
            </form>
        </div>

        <?php if (count($customers) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <?php
                        // ソート用パラメータ
                        $baseSortParams = [];
                        if (!empty($selectedBookstore)) $baseSortParams['bookstore_name'] = $selectedBookstore;
                        $baseSortParams['page'] = $page;
                        function sortLink($label, $field, $sort, $direction, $baseSortParams) {
                            $nextDir = ($sort === $field && $direction === 'asc') ? 'desc' : 'asc';
                            $arrow = '';
                            if ($sort === $field) {
                                $arrow = $direction === 'asc' ? '▲' : '▼';
                            }
                            $params = array_merge($baseSortParams, ['sort' => $field, 'direction' => $nextDir]);
                            $url = '?' . http_build_query($params);
                            return "<a href='$url' style='text-decoration:none;color:inherit;'>$label$arrow</a>";
                        }
                        ?>
                        <th><?= sortLink('顧客ID', 'customer_id', $sort, $direction, $baseSortParams) ?></th>
                        <th>顧客名</th>
                        <th><?= sortLink('累計売上金額', 'total_purchase_amt', $sort, $direction, $baseSortParams) ?></th>
                        <th><?= sortLink('平均リードタイム', 'avg_lead_time', $sort, $direction, $baseSortParams) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customers as $customer): ?>
                        <?php
                            // 統計情報テーブルから該当顧客の最新統計を取得
                            $stat = null;
                            if (isset($customer->customer_id)) {
                                $stat = \Cake\ORM\TableRegistry::getTableLocator()->get('Statistics')
                                    ->find()
                                    ->where(['customer_id' => $customer->customer_id])
                                    ->order(['calc_date' => 'DESC'])
                                    ->first();
                            }
                        ?>
                        <tr>
                            <td><?= h($customer->customer_id) ?></td>
                            <td><?= h($customer->name) ?></td>
                            <?php if ($stat): ?>
                                <td><?= h($stat->total_purchase_amt) ?></td>
                                <td><?= h($stat->avg_lead_time) ?></td>
                            <?php else: ?>
                                <td>-</td>
                                <td>-</td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php
                // ページングUI
                $totalPages = (int)ceil($total / $limit);
                $prevPage = $page > 1 ? $page - 1 : 1;
                $nextPage = $page < $totalPages ? $page + 1 : $totalPages;
                $queryParams = [];
                if (!empty($selectedBookstore)) {
                    $queryParams['bookstore_name'] = $selectedBookstore;
                }
                // ソート状態をページングにも維持
                if (!empty($sort)) {
                    $queryParams['sort'] = $sort;
                }
                if (!empty($direction)) {
                    $queryParams['direction'] = $direction;
                }
            ?>
            <div class="paging-ui">
                <?php if ($page > 1): ?>
                    <a href="?<?= http_build_query(array_merge($queryParams, ['page' => $prevPage])) ?>">&laquo; 前へ</a>
                <?php else: ?>
                    <span style="color:#ccc;">&laquo; 前へ</span>
                <?php endif; ?>
                <span>ページ <?= $page ?> / <?= $totalPages ?></span>
                <?php if ($page < $totalPages): ?>
                    <a href="?<?= http_build_query(array_merge($queryParams, ['page' => $nextPage])) ?>">次へ &raquo;</a>
                <?php else: ?>
                    <span style="color:#ccc;">次へ &raquo;</span>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>該当する顧客情報がありません。</p>
        <?php endif; ?>

        <div class="back-button">
            <?= $this->Html->link('戻る', ['controller' => 'Home', 'action' => 'index']) ?>
        </div>
    </div>
</body>
</html>