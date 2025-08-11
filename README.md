# 書店管理システム (MBS - Bookstore Management System)

## 概要

架空書店の紙ベースで行っている業務を効率化・デジタル化するために開発された書店管理システムです。
顧客管理から注文処理、納品管理、統計分析まで、書店運営に必要な機能を包括的に提供します。

## 使用技術・フレームワーク

- **言語**: PHP 8.1+
- **フレームワーク**: CakePHP 5.1
- **CSSフレームワーク**: Milligram (v1.3)
- **ライブラリ**: 
  - PhpSpreadsheet (Excel import/export機能)
  - MobileDetect (モバイルデバイス検出)
- **データベース**: MySQL/MariaDB
- **開発ツール**: 
  - PHPStan (静的解析)
  - PHPUnit (テスト)
  - CakePHP CodeSniffer (コード規約)

## 主な機能・画面

### 1. 顧客管理
- 顧客情報の新規登録
- 顧客情報の検索・一覧表示
- 顧客情報の編集・更新
- 連絡先・購買履歴の管理

### 2. 注文書管理
- 注文書の作成・登録
- 注文情報の検索・一覧表示
- 注文詳細の確認・編集
- 注文ステータスの管理

### 3. 納品管理
- 納品情報の登録・管理
- 納品確認・検品処理
- 返品処理の対応
- 納品ステータスの追跡

### 4. 統計情報
- 売上統計の集計・分析
- リードタイム分析
- 顧客別購買統計
- 期間別売上レポート

## インストール・セットアップ

### 前提条件
- PHP 8.1以上
- Composer
- MySQL/MariaDB
- Webサーバー (Apache/Nginx)

### インストール手順

1. **リポジトリのクローン**
```bash
git clone [repository-url]
cd bookstore_system
```

2. **依存関係のインストール**
```bash
composer install
```

3. **環境設定ファイルの作成**
```bash
cp config/app_local.example.php config/app_local.php
```

4. **データベース設定**
`config/app_local.php` でデータベース接続情報を設定してください。

5. **データベースマイグレーション**
```bash
bin/cake migrations migrate
```

6. **開発サーバーの起動**
```bash
bin/cake server -p 8765
```

7. **アクセス確認**
ブラウザで `http://localhost:8765` にアクセスしてください。

## 使用方法

### 基本操作
1. トップページから各機能にアクセス
2. 顧客情報を登録
3. 注文書を作成
4. 納品処理を実行
5. 統計情報で分析

### 統計情報計算のコマンド
ターミナルで以下のコマンドを実行すると、統計情報の計算処理が実行されます：
```bash
bin/cake customer_stats
```

### バッチ処理の設定（Windows環境）
タスクスケジューラの「操作」に `run_customer_stats.vbs` のフルパスを設定してください。

### Excel機能
- 顧客データのインポート/エクスポート
- 注文データの一括処理
- 統計レポートのExcel出力

## 開発・保守

### コード品質チェック
```bash
# コードスタイルチェック
composer cs-check

# 静的解析
composer stan

# テスト実行
composer test
```

### テスト
```bash
# 全テスト実行
bin/cake test

# 特定のテストクラス実行
bin/cake test App\Test\TestCase\Controller\CustomersControllerTest
```

## モバイル対応

レスポンシブデザインを採用し、スマートフォン・タブレットでの利用にも対応しています。
MobileDetectライブラリによる端末判定機能も実装されています。

## 作成者

**作成者名**: [作成者名を記入してください]

## ライセンス

MIT License

---

**注意**: 本システムは架空の書店業務を想定して開発されたサンプルシステムです。実際の運用の際は、セキュリティやデータバックアップなどの運用面での対策を十分に検討してください。
