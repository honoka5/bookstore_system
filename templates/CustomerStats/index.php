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
    <h1>顧客情報一覧</h1>
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
                    <th>顧客ID</th>
                    <th>書店名</th>
                    <th>顧客名</th>
                    <th>住所</th>
                    <th>電話番号</th>
                    <th>担当者名</th>
                    <th>配達先条件等</th>
                    <th>顧客登録日</th>
                    <th>備考</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                    <tr>
                        <td><?= h($customer->customer_id) ?></td>
                        <td><?= h($customer->bookstore_name) ?></td>
                        <td><?= h($customer->customer_name) ?></td>
                        <td><?= h($customer->address) ?></td>
                        <td><?= h($customer->tel) ?></td>
                        <td><?= h($customer->person_in_charge) ?></td>
                        <td><?= h($customer->delivery_condition) ?></td>
                        <td><?= h($customer->registered) ?></td>
                        <td><?= h($customer->remark) ?></td>
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
