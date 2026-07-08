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

## 実装したファイル

- `src/app/Services/PriceCalculator.php` - 税込計算・割引計算のサービスクラス（テスト対象）
- `src/app/Models/PostLike.php` - いいね機能のモデル
- `src/database/migrations/xxxx_create_post_likes_table.php` - post_likesテーブルのマイグレーション
- `src/database/factories/PostFactory.php` - テスト用投稿ダミーデータ
- `src/database/factories/TaskFactory.php` - テスト用タスクダミーデータ
- `src/tests/Unit/PriceCalculatorTest.php` - ユニットテスト（正常系・異常系）
- `src/tests/Unit/PriceCalculatorBoundaryTest.php` - 境界値テスト
- `src/tests/Unit/PostLikesTest.php` - いいね機能のユニットテスト（TDD）
- `src/tests/Feature/PostTest.php` - 投稿機能のFeature Test
- `src/tests/Feature/TaskTest.php` - タスク機能のFeature Test

## 学んだこと・つまったポイント

- `pestphp/pest` がPHP 8.3以上を要求していたため、PHP 8.2環境では `phpunit/phpunit` に切り替える必要があった
- `Post` モデルと `Task` モデルに `use HasFactory` が記述されていなかったため `factory()` が使えずエラーになった。モデルに `HasFactory` トレイトを追加することで解決した
- コードカバレッジの測定にはXdebugが必要で、`pecl install xdebug` でインストールし `php.ini` に設定を追加した
- `tests/Feature/Auth/` や `tests/Feature/ProfileTest.php` がPest形式で書かれていたため、PHPUnitに切り替えた際にエラーになった。該当ファイルを削除することで解決した
- TDDでは先にテストを書いて意図的にRedにしてから実装することで、「何を実装すべきか」が明確になった

## セットアップ手順

```bash
cd laravel-docker-app
docker compose up -d
docker compose exec app bash
php artisan migrate
php artisan test
```

## テスト実行結果## 実装したテスト一覧

| ファイル | テスト数 | 内容 |
|---|---|---|
| `PriceCalculatorTest` | 5個 | 正常系・異常系 |
| `PriceCalculatorBoundaryTest` | 7個 | 境界値テスト |
| `PostTest` | 9個 | CRUD・認証・認可・バリデーション |
| `TaskTest` | 8個 | CRUD・認証・認可・toggle |
| `PostLikesTest` | 4個 | TDD（Red→Green→Refactor） |
| **合計** | **33個** | |

## 使用技術

- PHP 8.2
- Laravel 12
- PHPUnit 11.5
- Xdebug 3.5
- MySQL 8.0
- Docker / Docker Compose