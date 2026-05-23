# Laravel Docker 開発環境

## 使用技術
- PHP 8.2
- Laravel
- MySQL 8.0
- Nginx
- Docker / Docker Compose

## セットアップ手順

### 1. リポジトリをクローン
git clone <リポジトリURL>
cd laravel-docker-app

### 2. コンテナを起動
docker compose up -d

### 3. Laravelをインストール
docker compose exec app bash
composer create-project laravel/laravel .
exit

### 4. .envを設定
src/.envのDB設定を以下に変更する
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret

### 5. マイグレーション実行
docker compose exec app php artisan migrate

## アクセス先
- Laravel: http://localhost
- phpMyAdmin: http://localhost:8080