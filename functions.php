<?php

// =====================================
// テーマ初期設定（theme support / ナビ / 画像サイズ）
// =====================================
function daymaga_setup() {
  add_theme_support( 'title-tag');
  add_theme_support( 'post-thumbnails');
  add_theme_support( 'automatic-feed-links');
  add_theme_support( 'site-icon' );
  add_theme_support( 'html5', [
    'search-form',
    'comment-form',
    'comment-list',
    'gallery',
    'caption',
    'style',
    'script',
  ]);

  register_nav_menus( [
    'global'       => 'グローバルナビ（ヘッダーPC）',
    'drawer'       => 'ドロワーメニュー（ヘッダーSP）',
    'footer-nav-1' => 'フッターナビ（左）',
    'footer-nav-2' => 'フッターナビ（右）',
  ]);

  add_image_size( 'card', 544, 306, true );
  add_image_size( 'hero', 566, 306, true );
  add_image_size( 'og', 1200, 630, true );
}
add_action( 'after_setup_theme', 'daymaga_setup');

// =====================================
// CSS / JS 読み込み
// =====================================
function daymaga_enqueue_assets() {
  wp_enqueue_style('daymaga-google-fonts', 'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;500;700&family=Zen+Maru+Gothic:wght@400;500;700&display=swap', [], null);
  wp_enqueue_style('daymaga-swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css', [], '12');
  wp_enqueue_style('daymaga-style', get_template_directory_uri() . '/css/style.css', [], '1.0.0');

  wp_enqueue_script('daymaga-main', get_template_directory_uri() . '/js/main.js', [ 'daymaga-swiper' ], '1.0.0', true);
  wp_script_add_data( 'daymaga-main', 'strategy', 'defer' );
  wp_enqueue_script('daymaga-swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js', [], '12', true);
  wp_script_add_data( 'daymaga-swiper', 'strategy', 'defer');
}
add_action('wp_enqueue_scripts', 'daymaga_enqueue_assets');

// =====================================
// ブロックエディタ用 CSS の除去
// =====================================
function daymaga_dequeue_block_library_css() {
  wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'wp-block-library-theme' );
  wp_dequeue_style( 'wp-blocks-style' );
}
add_action( 'wp_enqueue_scripts', 'daymaga_dequeue_block_library_css', 100 );

// =====================================
// ナビメニュー <li> へのクラス付与
// =====================================
function daymaga_nav_menu_li_class( $classes, $item, $args ) {
  switch ( $args->theme_location ) {
    case 'global':
      $classes[] = 'p-header__nav-item';
      break;
    case 'drawer':
      $classes[] = 'p-header__drawer-item';
      break;
    case 'footer-nav-1':
    case 'footer-nav-2':
      $classes[] = 'p-footer__item';
      break;
  }
  return $classes;
}
add_filter( 'nav_menu_css_class', 'daymaga_nav_menu_li_class', 10, 3 );

// =====================================
// body へのページ種別クラス付与
// =====================================
function daymaga_body_class( $classes ) {
  if ( is_tag() ) {
    $classes[] = 'p-tag-page';
  }
  if ( is_single() ) {
    $classes[] = 'p-single-page';
  }
  if ( is_archive() || is_home() ) {
    $classes[] = 'p-archive-page';
  }
  return $classes;
}
add_filter( 'body_class', 'daymaga_body_class' );

// =====================================
// ページネーション出力
// =====================================
function daymaga_pagination() {
  $links = paginate_links( [
    'type'      => 'array',
    'mid_size'  => 1,
    'prev_text' => '',
    'next_text' => '',
  ] );

  if ( ! $links ) {
    return;
  }
  echo '<nav class="c-pagination" aria-label="ページネーション">';
  echo '<ul class="page-numbers">';
    foreach ( $links as $link ) {
      echo '<li>' . $link . '</li>';
    }
  echo '</ul>';
  echo '</nav>';
}

// =====================================
// CTA ショートコード（記事内挿入用 [daymaga-cta]）
// =====================================
function daymaga_cta_shortcode( $atts ) {
  $atts = shortcode_atts(
    [
      'text'  => 'コンサルタント案件の紹介登録をする',
      'url'   => '#',
    ],
    $atts,
    'daymaga-cta'
  );

  ob_start();
  ?>
  <div class="p-single__cta">
    <a href="<?php echo esc_url( $atts['url'] ); ?>" class="p-single__cta-box"><?php echo esc_html( $atts['text'] ); ?></a>
  </div>
  <?php return ob_get_clean();
}
add_shortcode( 'daymaga-cta', 'daymaga_cta_shortcode' );

// =====================================
// テンプレ用データ: タグフィルターの大分類とタグ slug
// =====================================
function daymaga_tag_filter_groups() {
  return [
    '対象' => [ 'consulfirm', 'client', 'common' ],
    '分類' => [ 'strategy', 'it', 'business-improvement', 'hr', 'ma', ],
    '業界' => [ 'it', 'maker', 'trading', 'service', 'retail', 'media', 'finance', 'logistics', 'others', 'common' ],
  ];
}

// =====================================
// テンプレ用データ: アーカイブタブのカテゴリー
// =====================================
function daymaga_archive_tab_categories() {
  return [
    'all'       => 'すべて',
    'latest'    => '新着情報',
    'tips'      => 'TIPS',
    'interview' => 'インタビュー',
    'news'      => 'ニュース',
  ];
}

// =====================================
// テーマカスタマイザー（CTA URL 設定）
// =====================================
function daymaga_customize_register( $wp_customize ) {
  $wp_customize->add_section( 'daymaga_cta', [
    'title'    => 'CTA リンク先',
    'priority' => 30,
  ] );

  $wp_customize->add_setting( 'cta_primary_url', [
    'default'           => '#',
    'sanitize_callback' => 'esc_url_raw',
  ] );
  $wp_customize->add_control( 'cta_primary_url', [
    'label'       => '企業様向け CTA URL',
    'description' => 'ヘッダー「まずは無料相談」とCTAセクション「プロジェクトの相談をする」の両方に適用',
    'section'     => 'daymaga_cta',
    'type'        => 'url',
  ] );

  $wp_customize->add_setting( 'cta_secondary_url', [
    'default'           => '#',
    'sanitize_callback' => 'esc_url_raw',
  ] );
  $wp_customize->add_control( 'cta_secondary_url', [
    'label'       => 'コンサルタント向け CTA URL',
    'description' => 'ヘッダー「案件の紹介登録」とCTAセクション「案件の紹介を受ける」の両方に適用',
    'section'     => 'daymaga_cta',
    'type'        => 'url',
  ] );
}
add_action( 'customize_register', 'daymaga_customize_register' );

// =====================================
// アイキャッチ画像のalt取得    
// =====================================
// メディアライブラリで設定されたaltを優先、未設定なら記事タイトルにフォールバック
function daymaga_get_thumbnail_alt( $post_id = null ) {
  $post_id = $post_id ? : get_the_ID();
  $thumb_id = get_post_thumbnail_id( $post_id );
  $alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
  return ! empty( $alt ) ? $alt : get_the_title( $post_id );
}