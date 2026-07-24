## デプロイ手順（詳細）

### 1. EC2インスタンスの作成

- Ubuntu 26.04 LTS / t3.micro（無料利用枠）/ 東京リージョン（ap-northeast-1）
- キーペアを新規作成し `.pem` ファイルをダウンロード
- Elastic IPを割り当て、EC2に関連付けて固定IP化

### 2. EC2環境構築

```bash
ssh -i my-ec2-key.pem ubuntu@<Elastic IP>
sudo apt update && sudo apt upgrade -y
# Docker公式リポジトリを追加してインストール
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
sudo usermod -aG docker ubuntu
```

### 3. アプリの取得と設定

```bash
git clone -b week10/frontend https://github.com/misaki36/techmeets-month2.git
cd techmeets-month2/laravel-docker-app
cp .env.example .env       # DB接続情報などを設定
cp .env src/.env           # Laravel本体側にも配置
```

### 4. RDS（MySQL）の作成

- MySQL 8.4 / db.t4g.micro（無料利用枠）/ 東京リージョン
- 作成時に「EC2コンピューティングリソースに接続」でEC2インスタンスを指定
- パブリックアクセス：無効
- 最初のデータベース名：`laravel`

### 5. アプリの起動

```bash
docker compose up -d
docker compose exec app composer install --ignore-platform-req=php
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

### 6. セキュリティグループの調整（下記参照）

### 7. 動作確認

`http://<EC2のElastic IP>` にブラウザでアクセスし、Laravelアプリが表示されることを確認。

---

## セキュリティグループ設計

セキュリティグループは「AWSのファイアウォール」であり、**最小権限の原則**（必要な通信元・必要なポートだけを許可する）に基づいて設計した。

### EC2用セキュリティグループ（launch-wizard-1）

| タイプ | プロトコル | ポート | 送信元（ソース） | 開放理由 |
|---|---|---|---|---|
| SSH | TCP | 22 | 自分のIPアドレス/32（例: 202.243.86.21/32） | サーバーの運用・保守作業は自分だけが行うため、SSHログインは自分のグローバルIPからのみ許可した。0.0.0.0/0で全世界に開放すると、ブルートフォース攻撃（パスワード総当たり攻撃）や不正アクセスの対象になるリスクが高いため避けた |
| HTTP | TCP | 80 | 0.0.0.0/0（全世界） | LaravelアプリをWebサービスとして一般公開するため、誰でもアクセスできる必要がある。HTTPSではなくHTTPなのはWeek13でSSL化するまでの暫定対応 |

### RDS用セキュリティグループ（default: sg-00e0bf6560ca4b192）

| タイプ | プロトコル | ポート | 送信元（ソース） | 開放理由 |
|---|---|---|---|---|
| MySQL/Aurora | TCP | 3306 | EC2のセキュリティグループ（launch-wizard-1, sg-0943c42ce00601a55） | データベースには、アプリケーションサーバー（EC2）だけが接続できれば要件を満たせる。送信元をIPアドレスではなく「EC2のセキュリティグループID」で指定することで、EC2のIPアドレスが変わっても設定を変更する必要がなく、かつ他のリソースからのアクセスは一切ブロックされる。3306番をインターネットに公開すると、DB内容の窃取や改ざんに直結するリスクが非常に高いため、EC2以外からの接続は完全に遮断した |

### 設計時に意識したこと

- **アウトバウンド（送信）ルールはデフォルト（全許可）のまま**：セキュリティグループはインバウンド（受信）側で制限するのが基本方針であり、外向き通信（アプリからAPIを叩く等）まで制限すると運用の柔軟性が失われるため
- **ソースはできる限り「セキュリティグループID」で指定する**：IPアドレス指定だとインスタンス再作成時に設定し直す必要があるが、セキュリティグループID指定なら自動的に追従する
- **RDSのセキュリティグループはデフォルトのままではなく、明示的にEC2からのルールを追加した**：RDS作成ウィザードの「EC2コンピューティングリソースに接続」を選んでも、実際には`default`セキュリティグループの既存ルール（「同グループ内のみ許可」）は自動更新されず、EC2（別グループ）からの接続がブロックされる不具合を実機で確認したため、インバウンドルールを手動で追加して対処した