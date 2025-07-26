<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>顧客登録</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Yu Gothic', 'Hiragino Kaku Gothic ProN', 'Meiryo', sans-serif;
            background-color: #f5f5f5;
            height: 100vh;
            overflow: hidden;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
        }

        .main-content {
            padding: 15px;
            max-width: 900px;
            margin: 0 auto;
            background: white;
            height: calc(100vh - 60px);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            min-height: 0; /* フレックスアイテムの縮小を可能にする */
        }

        h1 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 12px; /* 16px → 12px */
            color: #333;
            text-align: center;
            letter-spacing: 0.3px;
        }

        h2 {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px; /* 14px → 10px */
            color: #555;
            border-bottom: 2px solid #007bff;
            padding-bottom: 4px; /* 6px → 4px */
            letter-spacing: 0.2px;
        }

        h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 6px; /* 8px → 6px */
            color: #0056b3;
            letter-spacing: 0.1px;
        }

        .help-text {
            background: #e7f3ff;
            padding: 10px; /* 12px → 10px */
            border-radius: 6px;
            margin-bottom: 12px; /* 16px → 12px */
            border-left: 4px solid #007bff;
            flex-shrink: 0; /* 縮小させない */
        }

        .help-text ul {
            margin-left: 16px;
            line-height: 1.4;
            font-size: 14px;
            font-weight: 400;
        }

        .help-text li {
            margin-bottom: 3px; /* 4px → 3px */
            letter-spacing: 0.05px;
        }

        .upload-section {
            background: #f8f9fa;
            padding: 14px; /* 16px → 14px */
            border-radius: 8px;
            margin-bottom: 10px; /* 12px → 10px */
            border: 1px solid #e9ecef;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0; /* フレックスアイテムの縮小を可能にする */
        }

        .form-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 0; /* フレックスアイテムの縮小を可能にする */
        }

        .form-group {
            margin-bottom: 12px; /* 14px → 12px */
            flex-shrink: 0; /* 縮小させない */
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
            color: #333;
            font-size: 15px;
            letter-spacing: 0.1px;
        }

        .file-input {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
            background: white;
            font-family: inherit;
        }

        .file-input:focus {
            border-color: #007bff;
            outline: none;
        }

        .checkbox-group {
            margin: 10px 0; /* 12px → 10px */
            padding: 10px; /* 12px → 10px */
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            flex: 1;
            min-height: 0; /* フレックスアイテムの縮小を可能にする */
            overflow-y: auto; /* 必要に応じてスクロール */
        }

        .checkbox-label {
            display: flex;
            align-items: flex-start;
            font-weight: 500;
            color: #856404;
            cursor: pointer;
            font-size: 15px;
            line-height: 1.4;
            letter-spacing: 0.05px;
        }

        .checkbox-input {
            margin-right: 8px;
            margin-top: 2px;
            transform: scale(1.2);
            flex-shrink: 0;
        }

        .warning-text {
            font-size: 13px;
            font-weight: 500;
            color: #dc3545;
            margin-top: 6px; /* 8px → 6px */
            line-height: 1.3;
            padding: 6px; /* 8px → 6px */
            background: #f8d7da;
            border-radius: 4px;
            border-left: 3px solid #dc3545;
            letter-spacing: 0.05px;
        }

        .upload-button {
            background: #28a745;
            color: white;
            padding: 10px 20px; /* 12px 24px → 10px 20px */
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            width: 100%;
            font-family: inherit;
            letter-spacing: 0.2px;
            margin-top: 10px; /* auto → 10px */
            flex-shrink: 0; /* 縮小させない */
        }

        .upload-button:hover {
            background: #218838;
        }

        .upload-button:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        .footer-section {
            flex-shrink: 0; /* 縮小させない */
            padding-top: 10px;
        }

        .back-button {
            background: #6c757d;
            color: white;
            padding: 8px 14px; /* 10px 16px → 8px 14px */
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
            transition: background 0.2s;
            display: inline-block;
            font-family: inherit;
            letter-spacing: 0.1px;
            /* align-self: flex-start; を削除して左寄せ */
        }

        .back-button:hover {
            background: #5a6268;
            text-decoration: none;
            color: white;
        }

        /* レスポンシブ対応 */
        @media (max-width: 768px) {
            body {
                font-size: 15px;
            }

            .main-content {
                padding: 10px; /* 12px → 10px */
                height: calc(100vh - 50px);
            }

            h1 {
                font-size: 22px;
                margin-bottom: 10px; /* 14px → 10px */
            }

            h2 {
                font-size: 18px;
                margin-bottom: 8px; /* 12px → 8px */
            }

            h3 {
                font-size: 16px;
                margin-bottom: 4px; /* 6px → 4px */
            }

            .upload-section {
                padding: 12px; /* 14px → 12px */
            }

            .help-text {
                padding: 8px; /* 10px → 8px */
                margin-bottom: 10px; /* 14px → 10px */
            }

            .help-text ul {
                font-size: 13px;
            }

            .checkbox-label {
                font-size: 14px;
            }

            .warning-text {
                font-size: 12px;
                padding: 5px; /* 6px → 5px */
            }

            .form-label,
            .upload-button,
            .back-button {
                font-size: 14px;
            }

            .upload-button {
                padding: 8px 16px; /* 10px 20px → 8px 16px */
            }

            .back-button {
                padding: 6px 12px; /* 8px 14px → 6px 12px */
            }
        }

        /* 小さな画面用 */
        @media (max-width: 480px) {
            body {
                font-size: 14px;
            }

            .main-content {
                padding: 8px; /* 10px → 8px */
            }

            .upload-section {
                padding: 10px; /* 12px → 10px */
            }

            h1 {
                font-size: 20px;
            }

            h2 {
                font-size: 17px;
            }

            h3 {
                font-size: 15px;
            }

            .checkbox-label {
                font-size: 13px;
            }

            .warning-text {
                font-size: 11px;
            }

            .help-text ul {
                font-size: 12px;
            }

            .form-label,
            .upload-button,
            .back-button {
                font-size: 13px;
            }

            .upload-button {
                padding: 7px 14px; /* 8px 16px → 7px 14px */
            }

            .back-button {
                padding: 5px 10px; /* 6px 12px → 5px 10px */
            }
        }
    </style>
</head>
<body>
    <!-- 共通ヘッダーを読み込み -->
    <?= $this->element('common_header') ?>

    <div class="main-content">
        <div class="content-wrapper">
            <h1>顧客登録</h1>

            <div class="help-text">
                <h3>Excel一括登録について</h3>
                <ul>
                    <li>1行目はヘッダー行として扱われます</li>
                    <li>列順序：顧客ID、店舗名、顧客名、担当者名、（空列）、電話番号、（空列）、備考</li>
                    <li>必須項目：顧客ID、店舗名、顧客名、電話番号</li>
                    <li>既存IDは更新、新規IDは登録されます</li>
                </ul>
            </div>

            <div class="upload-section">
                <h2>Excelで一括登録</h2>
                
                <?= $this->Form->create(null, ['type' => 'file', 'id' => 'uploadForm']) ?>
                    <div class="form-content">
                        <div class="form-group">
                            <?= $this->Form->control('excel_file', [
                                'type' => 'file',
                                'label' => ['text' => 'Excelファイルを選択', 'class' => 'form-label'],
                                'class' => 'file-input',
                                'accept' => '.xlsx,.xls',
                                'required' => true
                            ]) ?>
                        </div>

                        <div class="checkbox-group">
                            <?= $this->Form->control('delete_old_data', [
                                'type' => 'checkbox',
                                'label' => [
                                    'text' => '現在のデータを削除する（Excelファイルに含まれていない既存顧客を削除）',
                                    'class' => 'checkbox-label'
                                ],
                                'class' => 'checkbox-input',
                                'id' => 'deleteOldData'
                            ]) ?>
                            <div class="warning-text">
                                <strong>重要な注意事項</strong><br>
                                このオプションを有効にすると、Excelファイルに含まれていない既存の顧客データが削除されます。<br>
                                ただし、注文履歴または納品履歴がある顧客は削除されません。<br>
                                <strong>実行前に必ずバックアップを取ってください。</strong>
                            </div>
                        </div>

                        <?= $this->Form->hidden('excel_upload', ['value' => 1]) ?>
                        
                        <button type="submit" class="upload-button" id="uploadButton">
                            Excelアップロード
                        </button>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <div class="footer-section">
            <?= $this->Html->link('一覧に戻る', ['controller' => 'List', 'action' => 'customer'], ['class' => 'back-button']) ?>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('uploadForm');
            const uploadButton = document.getElementById('uploadButton');
            const deleteCheckbox = document.getElementById('deleteOldData');

            // チェックボックス変更時の警告
            deleteCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    const confirmed = confirm(
                        '警告\n\n' +
                        'このオプションを有効にすると、Excelファイルに含まれていない既存の顧客データが削除されます。\n' +
                        '（注文履歴または納品履歴がある顧客は除く）\n\n' +
                        '本当に実行しますか？'
                    );
                    
                    if (!confirmed) {
                        this.checked = false;
                    }
                }
            });

            // フォーム送信時の確認
            form.addEventListener('submit', function(e) {
                uploadButton.disabled = true;
                uploadButton.textContent = 'アップロード中...';
                
                if (deleteCheckbox.checked) {
                    const finalConfirm = confirm(
                        '最終確認\n\n' +
                        '古いデータ削除オプションが有効です。\n' +
                        'Excelファイルに含まれていない顧客データが削除されます。\n\n' +
                        '本当に実行しますか？'
                    );
                    
                    if (!finalConfirm) {
                        e.preventDefault();
                        uploadButton.disabled = false;
                        uploadButton.textContent = 'Excelアップロード';
                        return false;
                    }
                }
            });
        });
    </script>
</body>
</html>