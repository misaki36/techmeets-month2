## Week15: CI/CD（GitHub Actions）

### CIパイプライン構成

| ジョブ | 内容 |
|--------|------|
| lint | PHP CS Fixer・PHPStanによるコード品質チェック |
| test | PHPUnitによる自動テスト（lintが通った後に実行） |

### 使用ツール

- **PHP CS Fixer** - PSR12準拠のコードスタイルチェック
- **PHPStan（larastan）** - Laravelに対応した静的解析（レベル3）
- **GitHub Actions** - CI自動実行環境

### ワークフローファイル

`.github/workflows/ci.yml`

### ローカルでの実行

```bash
# コードスタイルチェック（修正はしない）
cd laravel-docker-app/src
vendor/bin/php-cs-fixer fix --dry-run --diff

# 静的解析
vendor/bin/phpstan analyse --memory-limit=256M
```

### 学んだこと・つまったポイント

- リポジトリのルートに`.github/workflows/`を置かないとActionsが認識されない
- DockerプロジェクトはLaravelが`src/`配下にあるため、`working-directory`の指定が必要
- PHPStanはLaravelの動的メソッドを理解できないため、larastanの導入が必要
- PHP CS Fixerのインストールでcomposer.lockが更新され、PHPバージョンの要件が上がる場合がある