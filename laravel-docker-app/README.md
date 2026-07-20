## Week13: 独自ドメイン + HTTPS化（GitHub Actions同様の詳細版）

### 公開URL
https://techmeets-app-kuwa.com

### 構成

| ステップ | 内容 |
|--------|------|
| ドメイン取得 | お名前.comで `techmeets-app-kuwa.com` を取得 |
| DNS設定 | Aレコードを EC2 Elastic IP（52.198.68.2）に設定、CNAME(www)を設定 |
| リバースプロキシ | ホストNginx → Dockerコンテナ(Nginx, port 8000) |
| HTTPS化 | Let's Encrypt（Certbot）で証明書取得、Nginx設定へ自動反映 |

### 使用ツール
- **Nginx** - ホスト側のリバースプロキシ
- **Certbot（python3-certbot-nginx）** - SSL証明書の取得・自動更新設定
- **Let's Encrypt** - 無料SSL証明書の発行元

### Nginx設定ファイル
`/etc/nginx/sites-available/techmeets-app-kuwa.conf`

- `techmeets-app-kuwa.com` : Laravelアプリへのリバースプロキシ（80→443リダイレクト含む）
- `www.techmeets-app-kuwa.com` : wwwなしドメインへ301リダイレクト

### コマンド確認結果

#### `dig techmeets-app-kuwa.com +short`
```
52.198.68.2
```
ドメインのAレコードを問い合わせた結果。EC2のElastic IPが正しく返っており、DNS設定が反映されていることを確認できる。

#### `curl -I https://techmeets-app-kuwa.com`
```
HTTP/1.1 200 OK
Server: nginx/1.28.3 (Ubuntu)
Content-Type: text/html; charset=utf-8
X-Powered-By: PHP/8.2.32
```
HTTPSアクセスに対し200 OKが返っており、Nginx経由でLaravel(PHP)アプリが正常に応答していることを確認できる。

#### `sudo certbot certificates`
```
Certificate Name: techmeets-app-kuwa.com
Domains: techmeets-app-kuwa.com www.techmeets-app-kuwa.com
Expiry Date: 2026-10-18 (VALID: 89 days)
```
Let's Encryptで発行された証明書情報。wwwあり・なし両方をカバーしており、Certbotの自動更新タイマーにより期限前に更新される。

### 学んだこと・つまったポイント
- コンテナ内のNginxがすでにホストのポート80を使用していたため、`docker-compose.yml`の`APP_PORT`を8000に変更し、`127.0.0.1:8000:80`とバインドしてホストNginxと競合しないようにした
- Certbot実行はDNS反映（Aレコード）が完了していないと失敗するため、`dig`コマンドでの事前確認が重要
- SSL証明書取得後、EC2セキュリティグループに443番ポート（HTTPS）のインバウンドルールが必要（80番だけでは繋がらない）
- Certbotが自動でNginx設定ファイルにSSL関連の記述を追記してくれるため、手動でのcertificate/key指定は最小限で済む
- www統一のリダイレクトは、Certbotが生成した443番のserver_nameからwwwを外し、www専用のリダイレクト用serverブロックを別途追加することで実現