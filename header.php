<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <?php 
    $og_title = wp_get_document_title();
    $og_url   = is_singular() ? get_permalink() : home_url( add_query_arg( null, null ) );
    $og_type  = is_singular() ? 'article' : 'website';
    $og_description = is_singular() ? get_the_excerpt() : get_bloginfo( 'description' );

    if (is_singular() && has_post_thumbnail() ) {
      $og_image = get_the_post_thumbnail_url( get_the_ID(), 'og' );
    } else {
      $og_image = get_template_directory_uri() . '/img/ogp.jpg';
    }
    ?>

    <meta
      name="description"
      content="<?php echo esc_attr( $og_description ); ?>"
    />

    <meta
      property="og:title"
      content="<?php echo esc_attr( $og_title ); ?>"
    />
    <meta
      property="og:description"
      content="<?php echo esc_attr( $og_description ); ?>"
    />
    <meta property="og:image" content="<?php echo esc_url( $og_image ); ?>" />
    <meta property="og:type" content="<?php echo esc_attr( $og_type ); ?>" />
    <meta property="og:url" content="<?php echo esc_url( $og_url ); ?>" />

    <meta name="twitter:card" content="summary_large_image" />

    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <!-- ===================================== -->
    <!-- ヘッダー -->
    <!-- ===================================== -->
    <header class="p-header">
      <div class="p-header__inner">
        <div class="p-header__brand">
          <p class="p-header__copy">ビジネスの未来を切り拓く。</p>
          <p class="p-header__logo">
            <a href="<?php echo esc_url( home_url( '/' )); ?>">
              <img
                src="<?php echo esc_url( get_template_directory_uri() . '/img/logo-text.png' ); ?>"
                alt="<?php bloginfo( 'name' ); ?>"
                width="331"
                height="84"
                class="p-header__logo-default"
              />
              <img
                src="<?php echo esc_url( get_template_directory_uri() . '/img/logo-text-color.png' ); ?>"
                alt=""
                width="320"
                height="66"
                class="p-header__logo-compact"
              />
            </a>
          </p>
          <p class="p-header__copy-sub">コンサルティングの専門情報メディア</p>
        </div>

        <div class="p-header__nav-box">
          <!-- pc専用 -->
          <nav class="p-header__nav" aria-label="グローバルナビ">
            <?php wp_nav_menu( [
              'theme_location' => 'global',
              'container'      => false,
              'menu_class'     => 'p-header__nav-list',
              'fallback_cb'    => false,
              'depth'          => 1,
            ]);
            ?>

          </nav>
          <div class="p-header__cta">
            <a href="<?php echo esc_url( get_theme_mod( 'cta_primary_url', '#' ) ); ?>" class="p-header__cta-btn p-header__cta-btn--primary">
              <span class="p-header__btn-label">コンサルをお探しの企業様</span>
              <span class="p-header__btn-main">まずは無料相談</span>
            </a>
            <a href="<?php echo esc_url( get_theme_mod( 'cta_secondary_url', '#' ) ); ?>" class="p-header__cta-btn p-header__cta-btn--secondary">
              <span class="p-header__btn-label">コンサルタントの方</span>
              <span class="p-header__btn-main">案件の紹介登録</span>
            </a>
          </div>
          <!-- sp専用 -->
          <div class="p-header__tools">
            <button
              class="p-header__hamburger js-hamburger"
              type="button"
              aria-label="メニューを開く"
            >
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
              <span aria-hidden="true"></span>
            </button>
            <a
              href="<?php echo esc_url( home_url( '/' ) . '#tag-filter' ); ?>"
              class="p-header__search p-header__search--sp"
              aria-label="検索"
            >
              <img src="<?php echo esc_url( get_template_directory_uri() . '/img/search-icon.png' ); ?>" alt="" width="46" height="46" />
              <!-- alt空でOK -->
            </a>
          </div>
        </div>
      </div>

      <!-- ===================================== -->
      <!-- ドロワーメニュー -->
      <!-- ===================================== -->
      <div class="p-header__drawer js-drawer">
        <div class="p-header__drawer-inner">
          <nav class="p-header__drawer-nav">
            <?php wp_nav_menu( [
              'theme_location' => 'drawer',
              'container'      => false,
              'menu_class'     => 'p-header__drawer-list',
              'fallback_cb'    => false,
              'depth'          => 1,
            ]);
            ?>
          </nav>
          <a
            href="<?php echo esc_url( home_url( '/' ) . '#tag-filter' ); ?>"
            class="p-header__search p-header__search--drawer"
            aria-label="検索"
          >
            <img src="<?php echo esc_url( get_template_directory_uri() . '/img/search-icon.png' ); ?>" alt="" width="46" height="46" />
            <!-- alt空でOK -->
          </a>
        </div>
      </div>
    </header>


