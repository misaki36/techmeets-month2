## Week15 課題 - CI/CD基礎（GitHub Actions）

### 概要
GitHub Actionsを使ってCI/CDパイプラインを構築した。コードをpushするたびに自動でLintチェックとテストが実行される仕組みを実装した。

### 実装内容

- **Lint自動チェック**
  - PHP CS Fixerによるコードスタイルチェック
  - PHPStanによる静的解析（larastan導入済み）
- **自動テスト**
  - PHPUnitのテストをCIで自動実行
- **パイプラインの流れ**
  - pushまたはPR作成時に①Lintチェック → ②テスト実行の順で自動実行

### セットアップ手順

```bash
cd laravel-docker-app
docker compose up -d
```

詳しい設定は`laravel-docker-app/README.md`を参照してください。

### 自動デプロイ
- mainブランチへのpush時にEC2サーバーへ自動デプロイ
- デプロイ先：`https://techmeets-app-kuwa.com`