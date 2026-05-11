<?php $groups = daymaga_tag_filter_groups(); ?>
<aside class="p-tag-filter" id="tag-filter">
    <div class="p-tag-filter__inner">
      <div class="p-tag-filter__head">
        <img
          src="<?php echo esc_url( get_template_directory_uri() . '/img/search-icon.png' ); ?>"
          alt=""
          class="p-tag-filter__icon"
          width="46"
          height="46"
          loading="lazy"
        />
        <h2 class="p-tag-filter__title">キーワードで絞り込む</h2>
      </div>
      <div class="p-tag-filter__body">
        <?php foreach ( $groups as $group_title => $tag_slugs ) : ?>
        <div class="p-tag-filter__group">
          <h3 class="p-tag-filter__group-title"><?php echo esc_html( $group_title ); ?></h3>
          <ul class="p-tag-filter__tag-list">
            <?php foreach ( $tag_slugs as $slug ) : ?>
            <?php $tag = get_term_by( 'slug', $slug, 'post_tag' ); ?>
            <?php if ( $tag  && ! is_wp_error( $tag ) ) : ?>
            <li>
              <a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>" class="c-tag">#<?php echo esc_html( $tag->name ); ?></a>
            </li>
            <?php endif; ?>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </aside>