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

## セットアップ手順

### バックエンド
```
cd laravel-docker-app
docker compose up -d
```

詳しい環境変数の設定・テスト方法は`laravel-docker-app/README.md`を参照してください。

## 利用可能なURL
- `http://localhost/checkout` - 決済開始（Stripeにリダイレクト）
- `http://localhost/checkout/success` - 決済完了画面
- `http://localhost/checkout/cancel` - 決済キャンセル画面
- `http://localhost/api/webhook/stripe` - Stripe Webhook受信エンドポイント（POST）