<?php get_header(); ?>
<main>
  <!-- ===================================== -->
  <!-- 投稿記事 -->
  <!-- ===================================== -->
  <article class="p-single">
    <div class="p-single__inner">
      <header class="p-single__header">
        <div class="p-single__meta">
          <div class="p-single__contents">
            <span class="p-single__lead-time">公開日</span>
            <time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="p-single__date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
          </div>
          <?php $categories = get_the_category();
          if ( ! empty( $categories ) ) :
          ?>
          <span class="c-category c-category--<?php echo esc_attr( $categories[0]->slug ); ?>"><?php echo esc_html( $categories[0]->name ); ?></span>
          <?php endif; ?>
        </div>
        <h1 class="p-single__title"><?php the_title(); ?></h1>
        <?php if ( has_post_thumbnail() ) : ?>
          <?php the_post_thumbnail( 'hero', [ 'class' => 'p-single__hero', 'alt' => esc_attr( daymaga_get_thumbnail_alt() ), ] ); ?>
        <?php endif; ?>
        <p class="p-single__lead">
          <?php echo esc_html( get_the_excerpt() ); ?>
        </p>
      </header>

      

      <div class="p-single__body c-prose">
        <?php the_content(); ?>
      </div>

      <?php $closing_text = get_field( 'closing_text' ); ?>
      <?php if ( $closing_text ) : ?>
      <p class="p-single__closing">
        <?php echo nl2br( esc_html( $closing_text ) ); ?>
      </p>
      <?php endif; ?>

      <!-- tags -->
      <?php $tags = get_the_tags(); ?>
      <?php if ( ! empty( $tags) ) : ?>
      <aside class="p-single__tags">
        <h3 class="p-single__tags-title">この記事のタグ</h3>
        <ul class="p-single__tags-list">
          <?php foreach ( $tags as $tag ) : ?>
          <li><a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>" class="c-tag">#<?php echo esc_html( $tag->name ); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </aside>
      <?php endif; ?>
    </div>
  </article>
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