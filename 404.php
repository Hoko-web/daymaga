<?php get_header(); ?>
<main>
  <section class="p-404">
    <div class="p-404__inner">
      <p class="p-404__code">404</p>
      <h1 class="p-404__title">ページが見つかりません</h1>
      <p class="p-404__text">
        お探しのページは削除されたか、<br />
        URLが変更された可能性があります。
      </p>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="c-more-button p-404__button">トップへ戻る</a>
    </div>
  </section>
</main>
<?php get_footer(); ?>
