# my-frontend

## 動かし方

### フロントエンド
cd my-frontend
npm run dev

### バックエンド
cd laravel-docker-app
docker compose up -d

ブラウザで http://localhost:5173 にアクセス

## コンポーネント分割の理由

App・TaskForm・TaskCardの3つに分割した。
Appは全体のデータ管理と各コンポーネントの呼び出しを担当し、
TaskFormはフォームの入力と送信のみ、TaskCardはタスク1件の表示のみを担当する。
役割を分けることで、修正が必要なときに該当ファイルだけを見ればよく、
同じカードを別のページで使い回すことも容易になる。