# ペットライフスタイル株式会社 - モックサイト

CakePHPを使用してペットライフスタイル株式会社のWebサイトを参考にしたモックサイトを作成し、Difyのオープンソースを使用してAIチャットbotを構築しました。

## 機能

- ペットライフスタイル株式会社のWebサイトを参考にしたデザイン
- Bootstrap 5を使用したレスポンシブデザイン
- Dify iframeチャットアプリの統合
- モーダルとフルページの両方でチャット機能を提供
- モダンなUI/UX

## セットアップ

### 1. 依存関係のインストール

```bash
composer install
```

### 2. Dify iframeチャットアプリ設定

1. [Dify Cloud](https://cloud.dify.ai/app) でアカウントを作成
2. 新しいアプリケーションを作成
3. チャットアプリのiframeコードを取得
4. 必要に応じてiframeのURLを更新

```html
<!-- 現在の設定 -->
<iframe
 src="https://udify.app/chatbot/YBbJEzBRr3IyodV7"
 style="width: 100%; height: 100%; min-height: 700px"
 frameborder="0"
 allow="microphone">
</iframe>
```

### 3. アプリケーションの起動

```bash
# 開発サーバーを起動
bin/cake server
```

ブラウザで `http://localhost:8765` にアクセス

## ファイル構成

```
pet-lifestyle-mock/
├── src/
│   └── Controller/
│       └── ChatbotController.php    # チャットボットAPI
├── templates/
│   ├── layout/
│   │   └── default.php             # メインレイアウト
│   └── Pages/
│       └── home.php                # ホームページ
├── webroot/
│   ├── css/
│   │   └── pet-lifestyle.css       # カスタムCSS
│   └── js/
│       └── pet-lifestyle.js        # カスタムJavaScript
├── config/
│   ├── app.php                     # アプリケーション設定
│   ├── dify.php                    # Dify API設定
│   └── routes.php                  # ルーティング設定
└── env.example                     # 環境変数例
```

## API エンドポイント

### チャットボット

- `POST /api/chatbot/send` - メッセージ送信
- `GET /api/chatbot/history` - 会話履歴取得
- `POST /api/chatbot/reset` - 会話リセット

## 技術スタック

- **Backend**: CakePHP 5.x
- **Frontend**: Bootstrap 5, JavaScript (ES6+)
- **AI**: Dify API
- **Styling**: Custom CSS, Font Awesome

## 主な機能

### チャットボット機能

1. **iframeチャットアプリ**: Difyのiframeチャットアプリを統合
2. **モーダル表示**: 右下のチャットボタンからモーダルでチャット
3. **フルページ表示**: `/chat` ページでフルサイズのチャット
4. **レスポンシブデザイン**: モバイル対応

### デザイン機能

1. **モダンなUI**: Bootstrap 5を使用
2. **ペットフレンドリー**: ペット関連のアイコンとカラー
3. **アクセシビリティ**: キーボードナビゲーション対応
4. **アニメーション**: スムーズなトランジション

## カスタマイズ

### Dify API設定の変更

`config/dify.php` ファイルでDify APIの設定を変更できます。

### スタイルのカスタマイズ

`webroot/css/pet-lifestyle.css` ファイルでスタイルをカスタマイズできます。

### JavaScript機能の追加

`webroot/js/pet-lifestyle.js` ファイルでJavaScript機能を追加できます。

## トラブルシューティング

### よくある問題

1. **Dify API接続エラー**
   - APIキーとアプリIDが正しく設定されているか確認
   - ネットワーク接続を確認

2. **JavaScript エラー**
   - ブラウザのコンソールでエラーメッセージを確認
   - 必要なライブラリが読み込まれているか確認

3. **スタイルが適用されない**
   - CSSファイルのパスを確認
   - ブラウザのキャッシュをクリア

## ライセンス

このプロジェクトはMITライセンスの下で公開されています。

## 貢献

プルリクエストやイシューの報告を歓迎します。# pet-lifestyle-mock
