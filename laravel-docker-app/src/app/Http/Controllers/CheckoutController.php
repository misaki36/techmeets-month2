<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Purchase; // Purchaseモデルを使えるようにインポート

class CheckoutController extends Controller
{
    // 「決済を始める」ボタンが押されたときに呼ばれるメソッド
    public function create(Request $request)
    {
        // StripeにAPIキーをセット（これがないとStripeと通信できない）
        Stripe::setApiKey(config('services.stripe.secret'));

        // Stripe側に「決済セッション」を作成する
        // 決済セッション = 「何をいくらで買うか」の情報をStripeに渡すもの
        $session = Session::create([
            'payment_method_types' => ['card'], // クレジットカード払いを指定

            'line_items' => [[  // 購入する商品の情報
                'price_data' => [
                    'currency'     => 'jpy',              // 通貨：日本円
                    'product_data' => ['name' => '商品名'], // 商品名
                    'unit_amount'  => 1000,               // 金額：1,000円
                ],
                'quantity' => 1, // 個数：1個
            ]],

            'mode' => 'payment', // 「1回払い」モード（定期払いではない）

            // 決済成功後にリダイレクトするURL
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',

            // 決済キャンセル後にリダイレクトするURL
            'cancel_url'  => route('checkout.cancel'),
        ]);

        // StripeのカードページにユーザーをリダイレクトさせてStripe側で決済させる
        return redirect($session->url);
    }

    // 決済完了後にStripeからリダイレクトされてくるメソッド
    public function success(Request $request)
    {
        // URLに含まれる session_id を取得する
        // 例：/checkout/success?session_id=cs_test_xxxx の cs_test_xxxx の部分
        $sessionId = $request->query('session_id');

        // session_id がある場合だけDBに保存する
        // （直接このURLにアクセスされた場合は保存しない）
        if ($sessionId) {
            // purchasesテーブルに購入履歴を保存する
            Purchase::create([
                'stripe_session_id' => $sessionId, // StripeのセッションID
                'product_name'      => '商品名',    // 購入された商品名
                'amount'            => 1000,        // 金額（円）
                'status'            => 'completed', // 決済ステータス
            ]);
        }

        // 完了ページを表示する
        return view('checkout.success');
    }
}