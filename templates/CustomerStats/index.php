<?php
/**
 * 書店名ごとに顧客情報を一覧表示し、計算ボタンで統計情報を計算する画面
 * @var \App\View\AppView $this
 * @var \Cake\Collection\CollectionInterface $bookstoreNames
 * @var string|null $selectedBookstore
 * @var \Cake\Collection\CollectionInterface $customers
 */
?>
<div class="customer-stats index content">
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
                            <td></td>
                            <td></td>
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
        <div class="paging-ui" style="margin-top:20px; text-align:center;">
            <?php if ($page > 1): ?>
                <a href="?<?= http_build_query(array_merge($queryParams, ['page' => $prevPage])) ?>" style="margin-right:20px;">&laquo; 前へ</a>
            <?php else: ?>
                <span style="color:#ccc; margin-right:20px;">&laquo; 前へ</span>
            <?php endif; ?>
            <span>ページ <?= $page ?> / <?= $totalPages ?></span>
            <?php if ($page < $totalPages): ?>
                <a href="?<?= http_build_query(array_merge($queryParams, ['page' => $nextPage])) ?>" style="margin-left:20px;">次へ &raquo;</a>
            <?php else: ?>
                <span style="color:#ccc; margin-left:20px;">次へ &raquo;</span>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p>該当する顧客情報がありません。</p>
    <?php endif; ?>

</div>

<div class="bottom-left-btn">
    <?= $this->Html->link('戻る', ['controller' => 'Home', 'action' => 'index'], ['class' => 'button']) ?>
</div>
