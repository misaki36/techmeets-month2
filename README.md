# Week14 課題 - テスト設計 + 品質管理

## 概要
LaravelアプリにPHPUnitを導入し、ユニットテスト・Feature Test・境界値テスト・TDDを実践した。あわせてXdebugによるコードカバレッジの測定も行った。

## 機能一覧

**基本課題：テストコード作成**
- `PriceCalculator` クラスを使ったユニットテスト（正常系・異常系）
- 境界値テスト（割引率0%・100%・-1%・101%など）
- 投稿機能（Post）のFeature Test（CRUD・認証・認可・バリデーション）
- タスク機能（Task）のFeature Test（CRUD・認証・認可・toggle）
- Xdebugを使ったコードカバレッジの測定

**練習課題1：ユニットテスト**
- `PriceCalculator` サービスクラスの正常系・異常系・境界値テスト
- AAAパターン（Arrange・Act・Assert）でテストを構造化

**練習課題2：Feature Test**
- 投稿・タスクのCRUD操作のFeature Test
- 認証（未ログインユーザーのアクセス拒否）のテスト
- 認可（他ユーザーのデータ操作禁止）のテスト

**練習課題3：TDD実践**
- いいね機能（`PostLike`）をTDD（Red→Green→Refactor）で実装
- テストを先に書いてから実装する開発フローを体験

## セットアップ手順

```bash
cd laravel-docker-app
docker compose up -d
```

詳しいテスト実行方法は `laravel-docker-app/README.md` を参照してください。

## テスト実行

```bash
docker compose exec app bash
php artisan migrate
php artisan test
```

## 実行結果

```
Tests: 33 passed (57 assertions)
Duration: 1.34s
```