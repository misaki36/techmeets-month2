# Week17: パフォーマンス最適化

## 概要
Lighthouseでパフォーマンスを計測し、N+1問題の解消・インデックス設計・Redisキャッシュの導入によりフロントエンドからバックエンドまで一貫したパフォーマンス改善を実施しました。

## 実装内容
- `app/Repositories/PostRepository.php` - eager loading・withCount・キャッシュの実装
- `database/migrations/2026_07_14_040347_add_index_to_posts_table.php` - インデックスの追加
- `docker-compose.yml` - Redisコンテナの追加

## Lighthouseスコア（改善後）
| 項目 | スコア |
|------|--------|
| Performance | 79 |
| Accessibility | 100 |
| Best Practices | 100 |
| SEO | 82 |

## 改善内容

### N+1問題の解消
| 対応 | 効果 |
|------|------|
| `with('user')` | 投稿者情報をまとめて取得 |
| `withCount('likes')` | いいね数をまとめて取得 |

### インデックス設計
| カラム | 理由 |
|--------|------|
| `user_id` | ユーザーの投稿一覧の検索を高速化 |
| `created_at` | 新着順の並び替えを高速化 |

### キャッシュ導入
| 項目 | 内容 |
|------|------|
| キャッシュドライバー | Redis |
| キャッシュ時間 | 60分 |
| キャッシュ削除タイミング | 投稿の作成・更新・削除時 |

## 改善結果
| 指標 | 改善前 | 改善後 |
|------|--------|--------|
| クエリ数（一覧ページ） | 52回 | 1回 |
| キャッシュ | なし | Redis（60分） |

## 今後の予定
- 練習課題3（画像のWebP変換・CDN配信）はAWSアカウント作成後に実施予定

## 学んだこと・つまったポイント
- `with('user')`を追加するだけでクエリ数が52回→3回に削減できる
- `withCount()`を使うことで集計処理のN+1も解消できる
- ローカルのPHPからDockerのRedisに接続する場合は`REDIS_HOST=127.0.0.1`にする必要がある
- `REDIS_CLIENT=predis`に変更しないとClass "Redis" not foundエラーが出る
- キャッシュ導入時はデータ更新時に`Cache::forget()`で削除しないと古いデータが表示され続ける