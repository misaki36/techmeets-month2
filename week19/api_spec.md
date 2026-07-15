# API仕様書：ToDoアプリ

## エンドポイント一覧

| メソッド | エンドポイント | 説明 |
|---------|--------------|------|
| GET | /api/todos | ToDo一覧取得 |
| POST | /api/todos | ToDo作成 |
| GET | /api/todos/{id} | ToDo詳細取得 |
| PUT | /api/todos/{id} | ToDo更新 |
| DELETE | /api/todos/{id} | ToDo削除 |

## API詳細

### ToDo一覧取得

【エンドポイント】
GET /api/todos

【認証】
必要（Bearer Token）

【クエリパラメータ】
- status (string, optional): 絞り込み（all, done, undone）

【レスポンス例（200 OK）】
{
  "data": [
    {
      "id": 1,
      "title": "買い物に行く",
      "done": false,
      "created_at": "2025-01-27T10:00:00Z"
    }
  ]
}

### ToDo作成

【エンドポイント】
POST /api/todos

【認証】
必要（Bearer Token）

【リクエストボディ】
{
  "title": "買い物に行く"
}

【バリデーション】
- title: 必須、1-200文字

【レスポンス例（201 Created）】
{
  "data": {
    "id": 1,
    "title": "買い物に行く",
    "done": false,
    "created_at": "2025-01-27T10:00:00Z"
  }
}

【エラーレスポンス例（422）】
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["The title field is required."]
  }
}

### ToDo更新

【エンドポイント】
PUT /api/todos/{id}

【認証】
必要（Bearer Token）

【リクエストボディ】
{
  "title": "買い物に行く（更新）",
  "done": true
}

【バリデーション】
- title: 1-200文字
- done: 真偽値

【レスポンス例（200 OK）】
{
  "data": {
    "id": 1,
    "title": "買い物に行く（更新）",
    "done": true,
    "created_at": "2025-01-27T10:00:00Z"
  }
}

### ToDo削除

【エンドポイント】
DELETE /api/todos/{id}

【認証】
必要（Bearer Token）

【レスポンス例（204 No Content）】
（レスポンスボディなし）

【エラーレスポンス例（404）】
{
  "message": "ToDo not found."
}