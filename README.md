## Week17: パフォーマンス最適化

### 実施した最適化
| 項目 | 内容 |
|------|------|
| N+1問題の解消 | `with('user')`・`withCount('likes')`でeager loading導入 |
| インデックス設計 | `user_id`・`created_at`にインデックスを追加 |
| キャッシュ導入 | RedisとCache::rememberで投稿一覧をキャッシュ |

### 使用ツール
- **Laravel Debugbar** - クエリ数の可視化
- **Redis** - インメモリキャッシュ
- **Lighthouse** - パフォーマンス計測

### Lighthouseスコア（改善後）
| 項目 | スコア |
|------|--------|
| Performance | 79 |
| Accessibility | 100 |
| Best Practices | 100 |
| SEO | 82 |

### 改善結果
| 指標 | 改善前 | 改善後 |
|------|--------|--------|
| クエリ数（一覧ページ） | 52回 | 1回 |
| キャッシュ | なし | Redis（60分） |