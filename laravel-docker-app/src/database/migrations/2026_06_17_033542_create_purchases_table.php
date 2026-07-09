<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migrationクラスを継承した無名クラス
// マイグレーション = 「DBのテーブルをコードで管理する仕組み」
// このファイルを実行すると purchases テーブルが作られる
return new class extends Migration
{
    // up() = マイグレーション実行時に呼ばれる（テーブルを作る処理）
    // php artisan migrate を実行したときに動く
    public function up(): void
    {
        // 'purchases'という名前のテーブルを作成する
        Schema::create('purchases', function (Blueprint $table) {

            // id列：1, 2, 3... と自動で番号が振られる主キー
            $table->id();

            // stripe_session_id列：StripeのセッションID（cs_test_xxxxx という文字列）
            // 決済完了後にStripeがくれるIDで、どの決済か特定するために使う
            $table->string('stripe_session_id');

            // product_name列：購入された商品の名前を保存する
            $table->string('product_name');

            // amount列：決済金額を整数で保存する（例：1000 = 1,000円）
            $table->integer('amount');

            // status列：決済のステータスを保存する
            // default('completed') = 何も指定しなければ 'completed' が入る
            $table->string('status')->default('completed');

            // created_at と updated_at の2列を自動で追加する
            // created_at = レコードが作られた日時
            // updated_at = レコードが最後に更新された日時
            $table->timestamps();
        });
    }

    // down() = マイグレーションを元に戻すときに呼ばれる
    // php artisan migrate:rollback を実行したときに動く
    // up()でやったことの逆をする（テーブルを削除する）
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};