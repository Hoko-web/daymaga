<?php get_header(); ?>
<main>
  <!-- ===================================== -->
  <!-- 全ての記事 -->
  <!-- ===================================== -->
  <section class="p-archive">
    <div class="p-archive__inner">
      <div class="p-archive__head">
        <div class="c-heading">
          <img
            src="<?php echo esc_url( get_template_directory_uri() . '/img/logo-color.png' ); ?>"
            class="c-heading__logo"
            alt=""
            width="84"
            height="46"
            loading="lazy"
          />
          <h1 class="c-heading__title">すべての記事</h1>
        </div>
        <ul class="p-archive__sort">
          <li class="p-archive__sort-item is-active">
            <a href="#" data-sort="date">新着順</a>
          </li>
          <li class="p-archive__sort-item">
            <a href="#" data-sort="views">人気順</a>
          </li>
        </ul>
      </div>

      <?php
      $tab_categories = daymaga_archive_tab_categories();
      
      // /category/xxx/ を開いてる時は xxx を初期アクティブに、それ以外は all
      $current_cat = is_category() ? get_queried_object()->slug : 'all';
      ?>
      <div class="p-archive__body p-archive__body--<?php echo esc_attr( $current_cat ); ?>">
        <ul class="p-archive__tab-list">
          <?php foreach ( $tab_categories as $slug => $name ) : ?>
            <li class="p-archive__tab p-archive__tab--<?php echo esc_attr( $slug ); ?><?php echo $slug === $current_cat ? ' is-active' : ''; ?>">
              <a href="#" data-category="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $name ); ?></a>
            </li>
          <?php endforeach; ?>
        </ul>

        <div class="p-archive__list">
          <?php
          $home_archive_query = new WP_Query( [
            'post_type'      => 'post',
            'posts_per_page' => -1,  // 全投稿取得（JSで6件ずつ表示）
          ] );
          if ( $home_archive_query->have_posts() ) :
            while ( $home_archive_query->have_posts() ) :
              $home_archive_query->the_post();
              $cats     = get_the_category();
              $tags     = get_the_tags();
              $card_cat = ! empty( $cats ) ? $cats[0]->slug : '';
          ?>
            <article class="c-card"
              data-category="<?php echo esc_attr( $card_cat ); ?>"
              data-date="<?php echo esc_attr( get_the_date( 'U' ) ); ?>"
              data-views="<?php echo function_exists( 'wpp_get_views' ) ? esc_attr( wpp_get_views( get_the_ID() ) ) : 0; ?>">
              <a href="<?php the_permalink(); ?>" class="c-card__link" aria-label="<?php the_title_attribute(); ?>"></a>
              <?php the_post_thumbnail( 'card', [ 'alt' => esc_attr( daymaga_get_thumbnail_alt() ), 'width' => 544, 'height' => 306, ] ); ?>
              <p class="c-card__date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></p>
              <h3 class="c-card__title"><?php the_title(); ?></h3>
              <?php if ( ! empty( $cats ) ) : ?>
                <span class="c-category c-category--<?php echo esc_attr( $cats[0]->slug ); ?>"><?php echo esc_html( $cats[0]->name ); ?></span>
              <?php endif; ?>
              <?php if ( ! empty( $tags ) ) : ?>
                <ul class="c-card__tag-list">
                  <?php foreach ( $tags as $tag ) : ?>
                    <li class="c-card__tag-item">
                      <a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>" class="c-tag">#<?php echo esc_html( $tag->name ); ?></a>
                    </li>
                  <?php endforeach; ?>
                </ul>
              <?php endif; ?>
            </article>
          <?php
            endwhile;
            wp_reset_postdata();
          endif;
          ?>
          <p class="p-archive__empty" hidden>このカテゴリの投稿は準備中です。</p>
        </div>
      </div>

      <!-- JSページネーション用の空コンテナ（JSが中身を生成） -->
      <nav class="c-pagination" aria-label="ページネーション" data-js-pagination>
        <ul class="page-numbers"></ul>
      </nav>
    </div>
  </section>

  <!-- ===================================== -->
  <!-- キーワードで絞り込む -->
  <!-- ===================================== -->
  <?php get_template_part( 'template-parts/tag-filter' ); ?>

  <!-- ===================================== -->
  <!-- cta -->
  <!-- ===================================== -->
  <?php get_template_part( 'template-parts/cta' ); ?>
</main>
<?php get_footer(); ?>