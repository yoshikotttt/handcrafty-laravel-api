# 手芸の写真共有プラットフォームAPI (Laravel)

このリポジトリは、手芸の写真共有プラットフォームのバックエンド機能を提供します。Reactのフロントエンドと統合するために特別に構築されたこのLaravel APIと連動して動作します。

## 主な機能

- Sanctumおよびbearer tokenを使用したユーザー認証。
- ユーザーポストのCRUD操作。
- 投稿に対する「いいね」機能。
- 投稿への「お気に入り」追加機能。
- ユーザーフォロー機能。

## 主要なAPIエンドポイント

1. **認証**
   - 新規登録: `/register`
   - ログイン: `/login`
   - ログアウト: `/logout`

2. **投稿**
   - 全投稿一覧: `/posts`
   - 個別投稿表示: `/posts/{item_id}`

3. **いいね**
   - いいね情報表示: `/posts/{item_id}/likes/info`
   - いいね追加: `/posts/{item_id}/likes`
   - いいね削除: `/posts/{item_id}/likes`

4. **お気に入り**
   - お気に入り追加: `/posts/{item_id}/favorites`
   - お気に入り削除: `/posts/{item_id}/favorites`

5. **フォロー**
   - フォロー追加: `/posts/{user_id}/follow`
   - フォロー削除: `/posts/{user_id}/follow`

このAPIの詳細や各エンドポイントの詳細は、関連するコントローラやルーティング設定を参照してください。
