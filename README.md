## Week16 課題 - Docker応用（イメージ最適化・セキュリティ・CI/CD）

### 概要
LaravelアプリのDockerイメージをDocker Hubに登録し、GitHub Actionsで自動ビルド・pushする仕組みを構築した。あわせてイメージの最適化・セキュリティ対策・ログ管理も実装した。

### 機能一覧

**基本課題：最適化されたDockerfile作成**
- マルチステージビルドによるイメージ最適化
- Alpine Linuxベースの軽量イメージ（97MB）
- 非rootユーザー（www-data）での実行
- ヘルスチェック実装

**練習課題1：イメージサイズ削減**
- Before: 747MB → After: 320MB（57%削減）

**練習課題2：セキュリティ対策（Trivy）**
- Trivyでイメージをスキャンし、HIGH/CRITICAL脆弱性をゼロに修正
- .envファイルのイメージへの混入を防止

**練習課題3：ログ収集**
- docker-compose.ymlにjson-fileドライバーでログ管理を設定

### セットアップ手順

```bash
cd laravel-docker-app
docker compose up -d
```

詳しい環境変数の設定・テスト方法は `laravel-docker-app/README.md` を参照してください。

### Docker Hubイメージ

```bash
docker pull kuwamisa/techmeets:latest
```
