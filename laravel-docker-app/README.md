# Week16: Docker応用 + CI/CD実践

## 概要
マルチステージビルドを使った最適化されたDockerfileを作成し、Docker HubへのイメージのpushとGitHub Actionsによる自動CI/CDパイプラインを構築した。

## 実装したファイル

- `Dockerfile` - マルチステージビルドによる最適化されたDockerfile
- `.dockerignore` - イメージに含めないファイルの設定
- `docker-compose.yml` - ログ管理設定を含むDocker Compose設定
- `.github/workflows/deploy.yml` - GitHub ActionsでDockerイメージを自動ビルド・pushするワークフロー

## 機能詳細

### マルチステージビルド
| ステージ | 役割 |
|---|---|
| composer-builder | PHPの依存関係をインストール |
| node-builder | フロントエンドをビルド |
| stage-2（最終） | 本番用の軽量イメージを生成 |

### イメージサイズ比較
| | Before | After |
|---|---|---|
| ベースイメージ | php:8.4-fpm | php:8.3-fpm-alpine |
| サイズ | 747MB | 320MB |
| 削減率 | - | **57%削減** |

### セキュリティ対策
- 非rootユーザー（www-data）で実行
- `.dockerignore` で `.env` ファイルをイメージから除外
- Trivyによるスキャンで HIGH/CRITICAL 脆弱性をゼロに修正

| 脆弱性 | 深刻度 | 対応 |
|---|---|---|
| c-ares | HIGH | apk upgradeで修正 |
| form-data | HIGH | 4.0.6にアップデート |
| shell-quote | CRITICAL | 1.8.4にアップデート |
| vite | HIGH | 7.3.5にアップデート |
| Stripeキー漏洩 | CRITICAL | .dockerignoreで修正 |

### CI/CDパイプライン
mainブランチへのpushをトリガーに、GitHub ActionsがDockerイメージを自動ビルドしてDocker Hubにpushする。
mainにpush
↓
GitHub Actionsが自動起動
↓
Dockerイメージをビルド
↓
Docker Hubに自動push
（コミットSHAタグ + latestタグ）

### ログ管理
docker-compose.ymlにjson-fileドライバーを設定し、ログを自動ローテーション管理する。
- 1ファイルあたり最大10MB
- 最大3ファイルまで保持

## セットアップ手順

### 1. Docker Hubからイメージをpull

```bash
docker pull kuwamisa/techmeets:latest
```

### 2. コンテナを起動

```bash
docker compose up -d
```

### 3. ログを確認

```bash
# リアルタイムでログを表示
docker compose logs -f app

# 最新100行を表示
docker compose logs --tail=100 app
```

## GitHub Secretsの設定

GitHub ActionsでDocker Hubに自動pushするために以下のシークレットを登録する。

| シークレット名 | 内容 |
|---|---|
| DOCKERHUB_USERNAME | Docker Hubのユーザー名 |
| DOCKERHUB_TOKEN | Docker Hubのアクセストークン |

## 学んだこと・つまったポイント

- マルチステージビルドを使うことで、ビルドツールを最終イメージに含めずにサイズを大幅削減できる。
- `.dockerignore` のパスは `Dockerfile` の `COPY` 命令の起点からの相対パスで指定する必要があり、`src/.env` のように正確に書かないと `.env` がイメージに混入する。
- `deploy.yml` はリポジトリのルートの `.github/workflows/` に置かないとGitHub Actionsに認識されない。
- GitHub ActionsのDocker buildは `context` の指定が重要で、`Dockerfile` のある場所を正しく指定する必要がある。

## 使用技術

- PHP 8.3
- Laravel 12
- Docker / Docker Compose
- Alpine Linux
- GitHub Actions
- Docker Hub
- Trivy（セキュリティスキャン）