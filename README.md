# Week10 課題 - React + Laravel API連携

## 概要
Vite + Reactで作成したフロントエンドから、LaravelのREST APIを呼び出してタスクの一覧表示・新規作成を行うアプリです。

## 機能一覧
- タスク一覧表示（Laravel APIからaxiosで取得）
- タスク新規作成（POSTリクエストでLaravelに送信）
- 完了/未完了の表示

## コンポーネント構成
- `App.jsx` - 全体のデータ管理・各コンポーネントの呼び出し
- `TaskForm.jsx` - フォームの入力と送信
- `TaskCard.jsx` - タスク1件の表示

## コンポーネント分割の理由
App・TaskForm・TaskCardの3つに分割した。Appは全体のデータ管理と各コンポーネントの呼び出しを担当し、TaskFormはフォームの入力と送信のみ、TaskCardはタスク1件の表示のみを担当する。役割を分けることで、修正が必要なときに該当ファイルだけを見ればよく、同じカードを別のページで使い回すことも容易になる。

## セットアップ手順

### バックエンド
cd laravel-docker-app
docker compose up -d

### フロントエンド
cd my-frontend
npm install
npm run dev

## 利用可能なURL
- `http://localhost:5173` - タスク一覧・新規作成
- `http://localhost/api/tasks` - タスク一覧API（GET）
- `http://localhost/api/tasks/{id}` - タスク1件API（GET）