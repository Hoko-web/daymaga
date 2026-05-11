<?php get_header(); ?>
    <main>
      <!-- ===================================== -->
      <!-- 全ての記事 -->
      <!-- ===================================== -->
      <section class="p-archive">
        <div class="p-archive__inner">
          <div class="p-archive__body p-archive__body--all">
            <ul class="p-archive__tab-list">
              <li class="p-archive__tab p-archive__tab--all is-active">
                <h1>#<?php single_tag_title(); ?> の検索結果</h1>
              </li>
            </ul>
            <div class="p-archive__list">
              <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
              <?php get_template_part( 'template-parts/card' ); ?>
              <?php endwhile; ?>
              <?php else : ?>
                <p>該当する記事がありません</p>
              <?php endif; ?>
            </div>
          </div>
          <?php daymaga_pagination(); ?>
        </div>
      </section>

      <!-- ===================================== -->
      <!-- 関連記事 -->
      <!-- ===================================== -->
      <section class="p-related">
        <div class="p-related__inner">
          <div class="p-related__head">
            <div class="c-heading">
              <img
                src="<?php echo esc_url( get_template_directory_uri() . '/img/logo-color.png' ); ?>"
                alt=""
                class="c-heading__logo"
                width="84"
                height="46"
                loading="lazy"
              />
              <h2 class="c-heading__title">関連記事</h2>
            </div>
            <div class="p-related__nav">
              <button
                class="p-related__prev"
                type="button"
                aria-label="前へ"
              ></button>
              <button
                class="p-related__next"
                type="button"
                aria-label="次へ"
              ></button>
            </div>
          </div>
          <div class="swiper p-related__swiper">
            <div class="swiper-wrapper">
              
              <?php $current_tags = wp_get_post_tags( get_the_ID(), [ 'fields' => 'ids' ] );
              $related_query = new WP_Query( [
                'post_type'        => 'post',
                'posts_per_page'   => 5,
                'tag__in'          => $current_tags,
                'post__not_in'     => [ get_the_ID() ],
                'orderby'          => 'date',
                'order'            => 'DESC',
                'ignore_sticky_posts' => true,
              ] );

              if ( $related_query->have_posts() ) : 
                while ( $related_query->have_posts() ) : 
                  $related_query->the_post();
              ?>
              <div class="swiper-slide">
                <?php get_template_part( 'template-parts/card' ); ?>
              </div>
              <?php endwhile; 
                    wp_reset_postdata(); 
                      endif; 
              ?>
            </div>
          </div>
          <div class="p-related__scrollbar"></div>
        </div>
      </section>

      <!-- ===================================== -->
      <!-- cta -->
      <!-- ===================================== -->
      <?php get_template_part( 'template-parts/cta' ); ?>
    </main>
<?php get_footer(); ?>