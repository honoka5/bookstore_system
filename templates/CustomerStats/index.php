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
                <option value="">--選択してください--</option>
                <?php foreach ($bookstoreNames as $name): ?>
                    <option value="<?= h($name->bookstore_name) ?>" <?= $selectedBookstore === $name->bookstore_name ? 'selected' : '' ?>>
                        <?= h($name->bookstore_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit">表示</button>
        </form>
    </div>
    <?php if ($selectedBookstore && count($customers) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>顧客名</th>
                    <th>累計売上金額</th>
                    <th>平均リードタイム</th>

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
                        <td><?= h($customer->customer_name) ?></td>
                        <?php if ($stat): ?>
                            <td><?= h($stat->total_purchace_amt) ?></td>
                            <td><?= h($stat->avg_leadtime) ?></td>
                        <?php else: ?>
                            <td></td>
                            <td></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div style="text-align:right; margin-top:1em;">
            <?= $this->Form->create(null, ['url' => ['action' => 'calculate']]) ?>
            <?= $this->Form->hidden('bookstore_name', ['value' => $selectedBookstore]) ?>
            <button type="submit">計算</button>
            <?= $this->Form->end() ?>
        </div>
    <?php elseif ($selectedBookstore): ?>
        <p>該当する顧客情報がありません。</p>
    <?php endif; ?>

</div>

<div class="bottom-left-btn">
    <?= $this->Html->link('戻る', ['controller' => 'Home', 'action' => 'index'], ['class' => 'button']) ?>
</div>
