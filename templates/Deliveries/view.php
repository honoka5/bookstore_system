<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Delivery $delivery
 */
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>納品書詳細</title>
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
            background: #1976d2;
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
        .details-table .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
        }
        .button-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-top: 32px;
        }
        .button-left {
            display: flex;
            gap: 12px;
        }
        .button-right {
            display: flex;
            gap: 12px;
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
        .button-edit {
            background-color: #ff9800;
        }
        .button-edit:hover {
            background: #f57c00;
        }
        .button-delete {
            background-color: #e53935;
        }
        .button-delete:hover {
            background: #b71c1c;
        }
        .button-back {
            background-color: #666;
        }
        .button-back:hover {
            background: #444;
        }
        .total-amount {
            font-weight: bold;
            font-size: 20px;
            color: #1976d2;
        }
        @media screen and (max-width: 768px) {
            .main-container {
                padding: 16px;
                margin: 0 8px;
            }
            .button-section {
                flex-direction: column;
                gap: 12px;
            }
            .button-left, .button-right {
                width: 100%;
                justify-content: center;
            }
            .info-table, .details-table {
                font-size: 14px;
            }
            .info-table th {
                width: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header Section -->
        <div class="header-section">
            <h2>納品書詳細</h2>
        </div>

        <!-- Delivery Information Section -->
        <div class="info-section">
            <table class="info-table">
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
                    <td class="total-amount"><?= h($delivery->delivery_total) ?> 円</td>
                </tr>
            </table>
        </div>

        <!-- Delivery Details Section -->
        <div class="details-section">
            <h3>納品内容（明細）</h3>
            <table class="details-table">
                <thead>
                    <tr>
                        <th>書籍名</th>
                        <th>数量</th>
                        <th>単価</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($delivery->delivery_content_management)): ?>
                        <?php foreach ($delivery->delivery_content_management as $content): ?>
                            <tr>
                                <td><?= h($content->book_title) ?></td>
                                <td style="text-align: center;"><?= h($content->quantity) ?></td>
                                <td style="text-align: right;"><?= h($content->unit_price) ?> 円</td>
                                <td style="text-align: right;"><?= h($content->total_amount) ?> 円</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="no-data">明細がありません</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Action Buttons Section -->
        <div class="button-section">
            <div class="button-left">
                <?= $this->Html->link('戻る', ['action' => 'index'], ['class' => 'button button-back']) ?>
            </div>
            <div class="button-right">
                <?= $this->Html->link('編集', ['action' => 'edit', $delivery->delivery_id], ['class' => 'button button-edit']) ?>
                <?= $this->Form->postLink('削除', ['action' => 'delete', $delivery->delivery_id], ['confirm' => __('Are you sure you want to delete # {0}?', $delivery->delivery_id), 'class' => 'button button-delete']) ?>
            </div>
        </div>
    </div>
</body>
</html>