# ============================================
# ステージ1: Composerで PHPの依存関係をインストール
# ============================================
FROM composer:latest AS composer-builder

WORKDIR /app

# composer.jsonとcomposer.lockだけ先にコピー（キャッシュ活用のため）
COPY src/composer.json src/composer.lock ./

# 本番用の依存関係のみインストール（開発用ツールは含めない）
RUN composer install --no-dev --optimize-autoloader --no-scripts

# ============================================
# ステージ2: Node.jsでフロントエンドをビルド
# ============================================
FROM node:20-alpine AS node-builder

WORKDIR /app

# package.jsonだけ先にコピー（キャッシュ活用のため）
COPY src/package*.json ./

# 依存関係をインストール
RUN npm ci

# フロントエンドのソースをコピー
COPY src/resources ./resources
COPY src/vite.config.js ./
COPY src/tailwind.config.js ./
COPY src/postcss.config.js ./

# フロントエンドをビルド
RUN npm run build

# ============================================
# ステージ3: 最終イメージ（本番用・軽量）
# ============================================
FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

# 必要なパッケージだけインストール（alpineは軽量なLinux）
RUN apk add --no-cache \
    mysql-client \
    && docker-php-ext-install pdo pdo_mysql

# ステージ1からPHPの依存関係だけコピー
COPY --from=composer-builder /app/vendor ./vendor

# ステージ2からビルド済みのフロントエンドだけコピー
COPY --from=node-builder /app/public/build ./public/build

# Laravelのソースコードをコピー
COPY src/ .

# ファイルの所有者をwebサーバー用ユーザーに変更
RUN chown -R www-data:www-data storage bootstrap/cache

# ヘルスチェック（コンテナが正常に動いているか確認する仕組み）
HEALTHCHECK --interval=30s --timeout=3s --retries=3 \
    CMD php-fpm -t || exit 1

# rootではなく一般ユーザーで実行（セキュリティ対策）
USER www-data

# PHP-FPMを起動
CMD ["php-fpm"]
