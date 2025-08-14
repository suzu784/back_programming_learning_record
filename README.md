## プログラミング学習記録アプリ

学習内容の記録・可視化を行うための Laravel + Vue アプリケーションです。バックエンドは Laravel、フロントエンドは Vite + Vue を利用しています。

### 技術スタック
- Backend: Laravel 9 (PHP ^8.0.2)
- Frontend: Vite, Vue 2
- UI/その他: Bootstrap, Axios, Chart.js ほか
- DB: `.env` で設定（ローカルは任意の RDB）

### セットアップ
1. 依存関係をインストール
   - `composer install`
   - `npm ci`
2. 環境ファイルを準備しアプリキーを生成
   - `cp .env.example .env`
   - `php artisan key:generate`
3. データベースを構成
   - `.env` の DB 接続を編集
   - `php artisan migrate --seed`

### 開発サーバの起動
- API: `php artisan serve`
- Vite: `npm run dev`

### ビルド
- `npm run build`

### テスト
- 実行: `php artisan test` もしくは `./vendor/bin/phpunit`

### 使用ツール / サービス
- PHPUnit: テストフレームワーク
- Vite: フロントビルドツール
