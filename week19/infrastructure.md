# インフラ構成図：主婦家計簿

## 構成図
【インターネット】
|
     | HTTPS (443)
     ↓
【ドメイン（お名前.com）】
     |
     ↓
【EC2インスタンス（Ubuntu 22.04）】
  ├── Nginx (ポート80/443)
  │    └── リバースプロキシ → PHP-FPM
  ├── Laravel アプリ（PHP 8.2）
  │    └── docker-compose で起動
  └── Let's Encrypt（SSL証明書）
     |
     | TCP (3306)
     ↓
【RDS（MySQL 8.0）】
     ↓
【S3バケット（レシート画像保存）】
     |
     ↓
【CloudFront（CDN）】

## 使用サービス一覧

| サービス | 用途 | 備考 |
|---------|------|------|
| EC2 | Webサーバー・アプリサーバー | Ubuntu 22.04 |
| RDS | データベース | MySQL 8.0 |
| S3 | レシート画像保存 | 非公開バケット |
| CloudFront | 画像配信（CDN） | S3と連携 |
| お名前.com | ドメイン管理 | 独自ドメイン |
| Let's Encrypt | SSL証明書 | 無料 |
| Docker | 環境構築 | docker-compose使用 |