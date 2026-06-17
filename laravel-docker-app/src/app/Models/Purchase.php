<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Purchaseモデル = purchasesテーブルと対応するクラス
// このクラスを使ってDBへの保存・取得ができる
class Purchase extends Model
{
    // $fillable = 一括代入を許可するカラムのリスト
    // これを設定しないとDBに保存できないので必須
    // 例：Purchase::create([...]) で一度に複数のカラムを保存できるようになる
    protected $fillable = [
        'stripe_session_id', // StripeのセッションID
        'product_name',      // 商品名
        'amount',            // 金額
        'status',            // 決済ステータス
    ];
}