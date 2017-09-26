<?php
  $terms = get_terms(
    array(
      'taxonomy' => 'cosmetic_category',
      'hide_empty' => 0,
      'orderby' => 'ID',
    ));
?>

<div class="product">
  <ul>
    <?php foreach ($terms as $key => $term) : ?>
      <?php if( !( $term->parent ) ) : ?>

        <li>
          <a href="<?php echo esc_url( home_url( '/' ) . $term->taxonomy . '/' . $term->slug); ?>">
            <div class="product-menu-item">
                <i class="icon-<?php echo esc_attr( $term->slug ); ?>"></i>
                <div class="product-name">
                  <?php echo $term->name; ?>
                </div>
            </div>

          </a>

        </li>

        <div class="arrow-down"></div>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>

</div>
