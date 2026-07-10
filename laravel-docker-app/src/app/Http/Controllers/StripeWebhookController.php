<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    // StripeからWebhook通知が来たときに呼ばれるメソッド
    public function handle(Request $request)
    {
        // Stripeから送られてきたデータ本体（JSON文字列）を取得
        $payload = $request->getContent();

        // Stripeが付けてくる「署名」を取得
        // 署名 = このリクエストが本当にStripeから来たことを証明するもの
        $sigHeader = $request->header('Stripe-Signature');

        // .envに設定したWebhook用のシークレットキーを取得
        $secret = config('services.stripe.webhook_secret');

        try {
            // 署名を検証しながらStripeのイベントデータを取得する
            // ここで署名が正しくなければ例外（エラー）が発生する
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);

        } catch (SignatureVerificationException $e) {
            // 署名が不正 → 誰かが偽のリクエストを送ってきた可能性がある
            // 400エラーを返して処理を中断する
            return response('Invalid signature', 400);
        }

        // イベントの種類によって処理を分ける
        // 'payment_intent.succeeded' = 決済が成功したときのイベント名
        if ($event->type === 'payment_intent.succeeded') {

            // イベントに含まれる決済情報を取り出す
            $paymentIntent = $event->data->object;

            // Laravelのログファイルに決済完了の記録を残す
            Log::info('決済完了: ' . $paymentIntent->id);
        }

        // Stripeに「正常に受信できました」と伝える
        return response('OK', 200);
    }
}
