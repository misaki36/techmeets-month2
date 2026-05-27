# 会員制ブログ

Laravel Breezeを使った認証機能付きブログアプリです。

## 機能一覧

- ユーザー登録・ログイン・ログアウト（Laravel Breeze）
- 投稿一覧表示（未ログインでも閲覧可能）
- 投稿作成（ログインユーザーのみ）
- 投稿編集・削除（自分の投稿のみ）

## セキュリティ対策

- XSS対策：Bladeの `{{ }}` による自動エスケープ
- CSRF対策：`@csrf` トークンをフォームに設置
- SQLインジェクション対策：EloquentによるORMを使用
- 認証：Laravel Breezeによるセッション管理
- 認可：自分の投稿以外は編集・削除不可（403エラー）

## 使用技術

- PHP 8.2
- Laravel 12
- MySQL 8.0
- Nginx
- Laravel Breeze（認証）
- Tailwind CSS

## セットアップ手順

```bash
# リポジトリをクローン
git clone <リポジトリURL>
cd laravel-docker-app

# Dockerを起動
docker compose up -d

# 依存パッケージをインストール
cd src
composer install

# 環境変数を設定
cp .env.example .env
docker compose exec app php artisan key:generate

# マイグレーション実行
docker compose exec app php artisan migrate

# フロントエンドをビルド
npm install && npm run dev
```

## 利用可能なURL

- `http://localhost/register` - ユーザー登録
- `http://localhost/login` - ログイン
- `http://localhost/posts` - ブログ一覧
- `http://localhost/dashboard` - ダッシュボード