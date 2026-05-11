<?php get_header(); ?>
<main>
  <h1 class="u-visually-hidden">
    <?php bloginfo( 'name' ); ?> | <?php bloginfo( 'description' ); ?>
  </h1>
  <!-- ===================================== -->
  <!-- カルーセル -->
  <!-- ===================================== -->
  <section class="p-pickup">
    <!-- Slider main container -->
    <div class="swiper p-pickup__swiper">
      <!-- Additional required wrapper -->
      <div class="swiper-wrapper">
        <?php $pickup_query = new WP_Query( [
          'post_type'        => 'post',
          'posts_per_page'   => 6,
          'meta_query'       => [
            [
              'key'   => 'is_pickup',
              'value' => '1',
            ],
          ],
        ] );

        if ( $pickup_query->have_posts() ) :
          while ( $pickup_query->have_posts() ) :
            $pickup_query->the_post();
        ?>
        <div class="swiper-slide">
          <?php get_template_part( 'template-parts/card' ); ?>
        </div>
        <?php endwhile;
          wp_reset_postdata();
              endif;
        ?>
      </div>

      <button
        class="p-pickup__prev"
        type="button"
        aria-label="前へ"
      ></button>
      <button
        class="p-pickup__next"
        type="button"
        aria-label="次へ"
      ></button>
    </div>
  </section>

  <!-- ===================================== -->
  <!-- 新着記事 -->
  <!-- ===================================== -->
  <section class="p-latest">
    <div class="p-latest__inner">
      <div class="c-heading">
        <img
          src="<?php echo esc_url( get_template_directory_uri() . '/img/logo-color.png' ); ?>"
          alt=""
          class="c-heading__logo"
          width="84"
          height="46"
          loading="lazy"
        />
        <h2 class="c-heading__title">新着記事</h2>
      </div>
      <div class="p-latest__list">
        <?php $latest_query = new WP_query( [
          'post_type'       => 'post',
          'posts_per_page'  => 3,
        ] );

        if ( $latest_query->have_posts() ) :
          while ( $latest_query->have_posts() ) :
            $latest_query->the_post();
        ?>
          <?php get_template_part( 'template-parts/card' ); ?>
        <?php endwhile; 
            wp_reset_postdata(); 
              endif; 
          ?>
      </div>
      
      <?php $archive_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' ); ?>
      <a href="<?php echo esc_url( $archive_url ); ?>" class="c-more-button">もっと見る</a>
    </div>
  </section>

  <!-- ===================================== -->
  <!-- よく読まれている記事 -->
  <!-- ===================================== -->
  <section class="p-popular">
    <div class="p-popular__inner">
      <div class="p-popular__head">
        <div class="c-heading c-heading--light">
          <img
            src="<?php echo esc_url( get_template_directory_uri() . '/img/logo-white.png' ); ?>"
            class="c-heading__logo"
            alt=""
            width="84"
            height="46"
            loading="lazy"
          />
          <h2 class="c-heading__title">よく読まれている記事</h2>
        </div>
        <div class="p-popular__nav">
          <button
            class="p-popular__prev"
            type="button"
            aria-label="前へ"
          ></button>

          <button
            class="p-popular__next"
            type="button"
            aria-label="次へ"
          ></button>
        </div>
      </div>
      <div class="swiper p-popular__swiper">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
          <?php $popular_query = new WP_Query( [
            'post_type'       => 'post',
            'posts_per_page'  => 5,
            'meta_query'      => [
              [
                'key'    => 'is_popular',
                'value'  => '1',
              ],
            ],
          ] );

          if ( $popular_query->have_posts() ) :
            while ( $popular_query->have_posts() ) :
              $popular_query->the_post();
              ?>
          <div class="swiper-slide">
            <?php get_template_part( 'template-parts/card' ); ?>
            </div>
            <?php endwhile; 
                wp_reset_postdata(); 
                  endif; 
              ?>
          
        </div>
        <div class="p-popular__scrollbar"></div>
      </div>
    </div>
  </section>

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
          <h2 class="c-heading__title">すべての記事</h2>
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
      ?>
      <div class="p-archive__body p-archive__body--all">
        <ul class="p-archive__tab-list">
          <?php foreach ( $tab_categories as $slug => $name ) : ?>
            <li class="p-archive__tab p-archive__tab--<?php echo esc_attr( $slug ); ?><?php echo $slug === 'all' ? ' is-active' : ''; ?>">
              <a href="#" data-category="<?php echo esc_attr( $slug ); ?>"><?php echo esc_html( $name ); ?></a>
            </li>
          <?php endforeach; ?>
        </ul>

        <div class="p-archive__list">
          <?php
          $front_archive_query = new WP_Query( [
            'post_type'      => 'post',
            'posts_per_page' => 30,
          ] );
          if ( $front_archive_query->have_posts() ) :
            while ( $front_archive_query->have_posts() ) :
              $front_archive_query->the_post();
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
      
      <?php $archive_url = get_option( 'page_for_posts' ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' ); ?>
      <a href="<?php echo esc_url( $archive_url ); ?>" class="c-more-button c-more-archive">もっと見る</a>
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