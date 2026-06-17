# Week12 課題 - 外部API連携（Stripe決済 / SendGridメール / Webhook）

## 概要
Laravelアプリに外部のWebサービス（Stripe・SendGrid）を組み込み、決済機能とメール送信機能を実装した。あわせてStripeのWebhookを使った非同期イベント処理も実装した。

## 機能一覧

### 基本課題：Stripeテスト決済機能
- Stripe Checkout Sessionを使った決済フロー（商品ページ→カード入力→完了ページ）
- テストカード番号（4242 4242 4242 4242）で決済が通ることを確認
- 決済完了後、購入履歴をLaravelのDB（purchasesテーブル）に保存

### 練習課題1：SendGridで会員登録メールを送信する
- SendGrid経由でのウェルカムメール送信
- Mailableクラス（WelcomeMail）による本文・件名の管理

### 練習課題2：Stripe Webhookで決済完了を処理する
- Stripe Webhookによる決済完了イベント（payment_intent.succeeded）の受信
- 署名検証（`Webhook::constructEvent()`）の実装
- 決済完了時にLaravelのログへ決済IDを記録

## 実装したファイル
- `src/app/Http/Controllers/CheckoutController.php` - Stripe Checkout Sessionの作成・決済完了後のDB保存処理
- `src/app/Http/Controllers/StripeWebhookController.php` - Webhook受信・署名検証・イベント処理
- `src/app/Mail/WelcomeMail.php` - SendGridで送るウェルカムメールのMailableクラス
- `src/app/Models/Purchase.php` - 購入履歴を保存するモデル
- `src/database/migrations/xxxx_create_purchases_table.php` - purchasesテーブルのマイグレーション
- `src/resources/views/checkout/` - 決済完了・キャンセル画面
- `src/resources/views/emails/welcome.blade.php` - ウェルカムメールのテンプレート
- `src/routes/api.php` - Webhook受信エンドポイント（CSRF対象外にするためapi.phpに配置）
- `src/routes/web.php` - 決済関連のルート（/checkout, /checkout/success, /checkout/cancel）

## 学んだこと・つまったポイント
- Stripe CheckoutはStripe側のページにリダイレクトする方式のため、カード番号が自分のサーバーを通らずセキュリティ面の責任範囲が小さくなる。
- SendGridでは送信元メールアドレスを事前に「Single Sender Verification」で認証する必要があり、`.env`の`MAIL_FROM_ADDRESS`と認証済みアドレスが一致していないと550エラー（Sender Identity未認証）になる。
- StripeのWebhookは署名検証が必須。検証用のシークレットキー（`whsec_...`）は`stripe listen`実行時に発行され、`STRIPE_WEBHOOK_SECRET`として`.env`に登録する。
- Webhook用のルートは`routes/web.php`に書くとCSRFトークンエラー（419）になるため、CSRF検証対象外の`routes/api.php`に書く必要がある。
- ローカル開発環境（Docker）で`php artisan serve`を使うと、DBのホスト名（`DB_HOST=db`）がDocker内部のホスト名のため接続できない。Dockerコンテナ内（Nginx経由のhttp://localhost）でアクセスするか、artisanコマンドを`docker exec`でコンテナ内から実行する必要がある。

## セキュリティ対策
- APIキー（Stripe・SendGrid）は`.env`にのみ記載し、`.gitignore`でGit管理対象から除外
- `.env.example`にはキー名のみを記載し、値はコミットしない
- Webhookは署名検証によって、Stripe以外からの偽リクエストを拒否

## セットアップ手順

### 1. Dockerの起動
```bash
cd laravel-docker-app
docker compose up -d
```

### 2. 環境変数の設定
`src/.env`に以下を設定（値は各自のAPIキー・テストモードのものを使用）
```
STRIPE_KEY=pk_test_xxxxx
STRIPE_SECRET=sk_test_xxxxx
STRIPE_WEBHOOK_SECRET=whsec_xxxxx

MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=SG.xxxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=認証済みの送信元メールアドレス
MAIL_FROM_NAME="${APP_NAME}"
```

### 3. マイグレーションの実行
```bash
docker exec -it laravel-docker-app-app-1 php artisan migrate
```

### 4. Webhookのローカル転送（別ターミナルで起動したままにする）
```bash
stripe login
stripe listen --forward-to localhost/api/webhook/stripe
```

## 利用可能なURL
- `http://localhost/checkout` - 決済開始（Stripeにリダイレクト）
- `http://localhost/checkout/success` - 決済完了画面
- `http://localhost/checkout/cancel` - 決済キャンセル画面
- `http://localhost/api/webhook/stripe` - Stripe Webhook受信エンドポイント（POST）
- `http://localhost:8080` - phpMyAdmin（DB確認用）

## テスト方法

### 決済テスト
1. `http://localhost/checkout` にアクセス
2. テストカード番号 `4242 4242 4242 4242`（有効期限：任意の未来日／CVC：任意の3桁）で決済
3. phpMyAdminで`purchases`テーブルに購入履歴が保存されていることを確認

### Webhookテスト
```bash
stripe trigger payment_intent.succeeded
```
`storage/logs/laravel.log`に「決済完了: pi_xxxxx」のログが記録されることを確認

## 使用技術
- PHP 8.5
- Laravel 12
- MySQL 8.0
- Nginx
- Docker / Docker Compose
- Stripe（決済API）
- SendGrid（メール送信API）