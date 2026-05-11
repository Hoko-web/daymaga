# DayMaga

コンサルティング業界の専門情報メディアを想定した、レスポンシブ Web サイトの WordPress カスタムテーマ。

静的 HTML / CSS / JavaScript として組み立てた4ページ構成のメディアサイトを、運用可能な WordPress テーマへ移行。テンプレート階層を活かした最小構成で、カテゴリーアーカイブ、タグ検索、カスタマイザー連携、JS によるアーカイブのフィルタ・ソート・ページネーションなどを実装している。

---

## 主要技術

| 領域           | 使用技術                                                     |
| -------------- | ------------------------------------------------------------ |
| バックエンド   | PHP 8 / WordPress 6.x                                        |
| フロントエンド | HTML5 / SCSS (Sass) / Vanilla JavaScript                     |
| ライブラリ     | Swiper.js v12                                                |
| 設計思想       | FLOCSS + BEM                                                 |
| レスポンシブ   | モバイルファースト（750 / 950 / 1300px の3ブレイクポイント） |
| 開発環境       | macOS / Local by Flywheel                                    |

---

## 実装機能

### ページテンプレート

| ファイル         | 役割                                                                       |
| ---------------- | -------------------------------------------------------------------------- |
| `front-page.php` | トップページ（ピックアップ / 新着 / 人気 / 全記事 / タグフィルター / CTA） |
| `category.php`   | カテゴリーアーカイブ + 投稿ページ（タブ切替で全記事を JS フィルタ）        |
| `tag.php`        | タグアーカイブ + 関連記事スライダー                                        |
| `single.php`     | 個別記事（目次・続きを読む展開・関連記事）                                 |
| `404.php`        | Not Found（カスタムスタイリング）                                          |
| `index.php`      | テンプレ階層フォールバック（`category.php` を委譲）                        |

### 共通テンプレートパーツ

- `template-parts/card.php` — 記事カード（6か所で共通利用）
- `template-parts/tag-filter.php` — キーワード絞り込み（PHP 配列で大分類管理）
- `template-parts/cta.php` — CTA ボタン

### WordPress 連携

- `wp_nav_menu()` による全ナビゲーション動的化（グローバル / ドロワー / フッター左右）
- WP-PostViews プラグイン連携の人気記事ソート（プラグイン非導入時のフォールバック実装）
- アイキャッチ画像のサイズ別登録（card / hero / og）
- OGP / Twitter Card 動的生成（記事ページはアイキャッチ画像と抜粋を反映）

### JavaScript

- アーカイブのカテゴリーフィルタ + 並び順切替（新着 / 人気） + ページネーション
- カテゴリーアーカイブ URL に応じた初期タブ自動アクティブ化（`/category/tips/` で TIPS タブ）
- 投稿数に応じた Swiper の loop 制御（少件数時の表示崩れ対策）
- 記事 0 件時のスタイル付き空状態表示
- 続きを読むボタンと目次リンクの連動展開
- ハンバーガー / ドロワー、ヘッダーのスクロール時縮小

### コーディング品質

- IIFE による JS スコープ分離（グローバル汚染対策）
- `esc_url` / `esc_attr` / `esc_html` の使い分けによる出力エスケープ徹底
- BEM ベースのクラス命名規則（`.p-archive__body--tips` など）

---

## 仕様からの変更点（改善方向）

### CTA リンク先の管理画面化

仕様書ではヘッダーCTAをページ内の中間CTAセクションへアンカー遷移させる想定だったが、実運用で外部LP・別ドメインフォーム等への差し替えが発生することを想定し、テーマカスタマイザーに「CTA リンク先」セクションを追加。
ヘッダー2種のCTAボタンと中間CTAセクションの計4ボタンを、管理画面から **企業様向け / コンサルタント向け** の2URL設定で一元管理できるようにした。

- 設定: `functions.php` `daymaga_customize_register()`
- ヘッダー側参照: `header.php`（`p-header__cta-btn--primary` / `--secondary`）
- 中間CTA側参照: `template-parts/cta.php`

---

## ディレクトリ構成

```
Day-Maga/
├─ functions.php          テーマセットアップ・ヘルパー関数
├─ header.php             共通ヘッダー
├─ footer.php             共通フッター
├─ front-page.php         トップ
├─ category.php           カテゴリー / 投稿アーカイブ
├─ tag.php                タグアーカイブ
├─ single.php             個別記事
├─ 404.php                Not Found
├─ index.php              フォールバック
├─ style.css              テーマ識別ファイル
│
├─ template-parts/        共通パーツ
│  ├─ card.php
│  ├─ tag-filter.php
│  └─ cta.php
│
├─ scss/
│  ├─ style.scss
│  ├─ foundation/         リセット・変数・mixin
│  └─ object/
│     ├─ component/       再利用可能 UI（card / button / heading / prose）
│     └─ project/         セクション固有（archive / header / footer / single / swiper / notfound）
│
├─ css/style.css          コンパイル後 CSS
├─ js/main.js             JavaScript
└─ img/                   画像アセット
```

---
