<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Delivery $delivery
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Delivery'), ['action' => 'edit', $delivery->delivery_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Delivery'), ['action' => 'delete', $delivery->delivery_id], ['confirm' => __('Are you sure you want to delete # {0}?', $delivery->delivery_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Deliveries'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Delivery'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="deliveries view content">
            <h3><?= h($delivery->delivery_id) ?> の納品書</h3>
            <table>
                <tr>
                    <th>納品書ID</th>
                    <td><?= h($delivery->delivery_id) ?></td>
                </tr>
                <tr>
                    <th>顧客名</th>
                    <td><?= h($delivery->customer->name ?? $delivery->customer_id) ?></td>
                </tr>
                <tr>
                    <th>注文書ID</th>
                    <td><?= h($delivery->order_id) ?></td>
                </tr>
                <tr>
                    <th>納品日</th>
                    <td><?= h($delivery->delivery_date) ?></td>
                </tr>
                <tr>
                    <th>合計金額</th>
                    <td><?= h($delivery->delivery_total) ?></td>
                </tr>
            </table>

            <h4>納品内容（明細）</h4>
            <table>
                <tr>
                    <th>書籍名</th>
                    <th>数量</th>
                    <th>単価</th>
                    <th>金額</th>
                </tr>
                <?php if (!empty($delivery->delivery_content_management)): ?>
                    <?php foreach ($delivery->delivery_content_management as $content): ?>
                    <tr>
                        <td><?= h($content->book_title) ?></td>
                        <td><?= h($content->quantity) ?></td>
                        <td><?= h($content->unit_price) ?></td>
                        <td><?= h($content->total_amount) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">明細がありません</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>