<?php 
/**                                                                              
 * 以下の2か所には JS フィルタ用の data属性付きカードが直接書かれており、         
 * このテンプレートを使っていません。デザインを変更する場合は、両方修正してください。
 *  category.php   「すべての記事」セクション（タブ切り替え）
 *  front-page.php 「すべての記事」セクション（タブ切り替え）                  
 */
$categories = get_the_category();                                                 
$tags       = get_the_tags();                                                     
?>
<article class="c-card">                                                          
  <a href="<?php the_permalink(); ?>" class="c-card__link" aria-label="<?php the_title_attribute(); ?>"></a>                                                   
  <?php the_post_thumbnail( 'card', [ 'alt' => esc_attr( daymaga_get_thumbnail_alt() ), 'width' => 544, 'height' => 306, ] ); ?>                                                          
  <p class="c-card__date"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></p>
  <h3 class="c-card__title"><?php the_title(); ?></h3>                                                                           
  <?php if ( ! empty( $categories ) ) : ?>                                        
    <span class="c-category c-category--<?php echo esc_attr( $categories[0]->slug ); ?>"><?php echo esc_html( $categories[0]->name ); ?></span>                     
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