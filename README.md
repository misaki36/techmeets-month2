## Week13: 独自ドメイン + HTTPS化

### 概要
独自ドメインを取得し、EC2上のLaravelアプリをHTTPSで公開しました。

### 実装内容
- 独自ドメイン `techmeets-app-kuwa.com` を取得
- DNS Aレコードを設定し、EC2のElastic IPと紐付け
- ホストNginxをリバースプロキシとして設置し、Dockerコンテナへ転送
- Let's Encrypt（Certbot）でSSL証明書を取得しHTTPS化
- HTTP→HTTPS、www→wwwなしの自動リダイレクトを設定

### 動作確認
- [x] `https://techmeets-app-kuwa.com` にブラウザでアクセスし、鍵マークが表示されることを確認
- [x] `http://` アクセス時に自動で `https://` へリダイレクトされることを確認
- [x] `www.techmeets-app-kuwa.com` アクセス時に wwwなしへリダイレクトされることを確認
- [x] `sudo certbot certificates` で証明書の有効性を確認

### 今後追加予定
- SSL証明書の自動更新の動作確認（`certbot renew --dry-run`）