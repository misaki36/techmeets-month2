<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // user_idにインデックスを追加（ユーザーの投稿一覧を速く取得するため）
            $table->index('user_id');

            // created_atにインデックスを追加（新着順の並び替えを速くするため）
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // ロールバック時にインデックスを削除
            $table->dropIndex(['user_id']);
            $table->dropIndex(['created_at']);
        });
    }
};