<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// Mailableクラス = メールの「雛形」を定義するクラス
// このクラスを使ってメールの件名・本文・送信先などを設定する
class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    // コンストラクタ = このクラスを呼び出すときに渡す値を定義する
    // $userName = メールに表示するユーザー名
    // public にすることでビュー（メールのテンプレート）からも使える
    public function __construct(public string $userName) {}

    // envelope() = メールの「封筒」部分を定義する
    // 件名（subject）を設定する
    public function envelope(): Envelope
    {
        return new Envelope(subject: 'ご登録ありがとうございます');
    }

    // content() = メールの「本文」部分を定義する
    // どのビューファイルを使って本文を作るかを指定する
    public function content(): Content
    {
        return new Content(view: 'emails.welcome');
    }
}