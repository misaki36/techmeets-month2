# DB設計書：ブログシステム

## テーブル一覧
- users（ユーザー）
- posts（投稿）
- comments（コメント）
- tags（タグ）

## テーブル定義

### users（ユーザー）

| カラム名 | 型 | NULL | デフォルト | 説明 |
|---------|-----|------|-----------|------|
| id | BIGINT | NO | AUTO | ユーザーID（PK） |
| name | VARCHAR(50) | NO | - | ユーザー名 |
| email | VARCHAR(100) | NO | - | メールアドレス |
| password | VARCHAR(255) | NO | - | パスワード（ハッシュ） |
| created_at | TIMESTAMP | NO | CURRENT | 作成日時 |
| updated_at | TIMESTAMP | NO | CURRENT | 更新日時 |

【インデックス】
- PRIMARY KEY (id)
- UNIQUE KEY (email)

### posts（投稿）

| カラム名 | 型 | NULL | デフォルト | 説明 |
|---------|-----|------|-----------|------|
| id | BIGINT | NO | AUTO | 投稿ID（PK） |
| user_id | BIGINT | NO | - | ユーザーID（FK） |
| title | VARCHAR(200) | NO | - | タイトル |
| content | TEXT | NO | - | 本文 |
| published | BOOLEAN | NO | false | 公開状態 |
| created_at | TIMESTAMP | NO | CURRENT | 作成日時 |
| updated_at | TIMESTAMP | NO | CURRENT | 更新日時 |

【インデックス】
- PRIMARY KEY (id)
- INDEX (user_id)
- INDEX (created_at)

【外部キー】
- user_id REFERENCES users(id) ON DELETE CASCADE

### comments（コメント）

| カラム名 | 型 | NULL | デフォルト | 説明 |
|---------|-----|------|-----------|------|
| id | BIGINT | NO | AUTO | コメントID（PK） |
| post_id | BIGINT | NO | - | 投稿ID（FK） |
| user_id | BIGINT | NO | - | ユーザーID（FK） |
| content | TEXT | NO | - | コメント本文 |
| created_at | TIMESTAMP | NO | CURRENT | 作成日時 |
| updated_at | TIMESTAMP | NO | CURRENT | 更新日時 |

【インデックス】
- PRIMARY KEY (id)
- INDEX (post_id)
- INDEX (user_id)

【外部キー】
- post_id REFERENCES posts(id) ON DELETE CASCADE
- user_id REFERENCES users(id) ON DELETE CASCADE

### tags（タグ）

| カラム名 | 型 | NULL | デフォルト | 説明 |
|---------|-----|------|-----------|------|
| id | BIGINT | NO | AUTO | タグID（PK） |
| name | VARCHAR(50) | NO | - | タグ名 |
| created_at | TIMESTAMP | NO | CURRENT | 作成日時 |

【インデックス】
- PRIMARY KEY (id)
- UNIQUE KEY (name)

### post_tags（投稿とタグの中間テーブル）

| カラム名 | 型 | NULL | デフォルト | 説明 |
|---------|-----|------|-----------|------|
| post_id | BIGINT | NO | - | 投稿ID（FK） |
| tag_id | BIGINT | NO | - | タグID（FK） |

【外部キー】
- post_id REFERENCES posts(id) ON DELETE CASCADE
- tag_id REFERENCES tags(id) ON DELETE CASCADE

## ER図

```
users (1) ----< (N) posts
users (1) ----< (N) comments
posts (1) ----< (N) comments
posts (N) >----< (N) tags  ※post_tags中間テーブル経由
```