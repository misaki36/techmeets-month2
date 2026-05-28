# Week8 課題 - Laravel認証 + セキュリティ

## 概要
Laravel Breezeを使った認証機能付きの会員制ブログと掲示板アプリです。

## 基本課題：会員制ブログ

### 機能一覧
- ユーザー登録・ログイン・ログアウト（Laravel Breeze）
- 投稿一覧表示（未ログインでも閲覧可能）
- 投稿作成（ログインユーザーのみ）
- 投稿編集・削除（自分の投稿のみ）

### セキュリティ対策
- XSS対策：Bladeの `{{ }}` による自動エスケープ
- CSRF対策：`@csrf` トークンをフォームに設置
- SQLインジェクション対策：EloquentによるORMを使用
- 認証：Laravel Breezeによるセッション管理
- 認可：自分の投稿以外は編集・削除不可（403エラー）

## 練習課題1：ログイン機能付き掲示板

### 機能一覧
- 投稿一覧表示（未ログインでも閲覧可能）
- 投稿作成（未ログインでも可能・匿名投稿）
- 投稿削除（自分の投稿のみ・ログイン必須）

## 練習課題2：セキュリティテスト
詳細は `laravel-docker-app/SECURITY_TEST_REPORT.md` を参照してください。

## セットアップ手順

```bash
cd laravel-docker-app
docker compose up -d
cd src
composer install
cp .env.example .env
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
npm install && npm run dev
```

## 利用可能なURL
- `http://localhost/register` - ユーザー登録
- `http://localhost/login` - ログイン
- `http://localhost/posts` - ブログ一覧
- `http://localhost/threads` - 掲示板
- `http://localhost/dashboard` - ダッシュボード