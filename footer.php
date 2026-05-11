    <footer class="p-footer">
      <div class="p-footer__inner">
        <div class="p-footer__container">
          <a href="<?php echo esc_url( home_url() ); ?>" class="p-footer__logo">
            <img src="<?php echo esc_url( get_template_directory_uri() . '/img/logo-text-white.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="468" height="96" loading="lazy" />
          </a>
          <nav class="p-footer__nav" aria-label="フッターナビゲーション">
            <?php wp_nav_menu( [
              'theme_location' => 'footer-nav-1',
              'container'      => false,
              'menu_class'     => 'p-footer__list',
              'fallback_cb'    => false,
              'depth'          => 1,
            ]);
            ?>
            <?php wp_nav_menu( [
              'theme_location' => 'footer-nav-2',
              'container'      => false,
              'menu_class'     => 'p-footer__list',
              'fallback_cb'    => false,
              'depth'          => 1,
            ]);
            ?>
          </nav>
        </div>
        <small class="p-footer__copy">©<?php echo date( 'Y' ); ?> Daytra Consul</small>
        <p class="p-footer__caution">
          このサイトはCrownCat株式会社様のご協力のもと作成したコーディング用の練習課題です。実在の人物・団体とは関係ありません。
        </p>
      </div>
    </footer>
    <?php wp_footer(); ?>
  </body>
</html>
