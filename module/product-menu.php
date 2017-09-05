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
    <?php $icon = $term->slug; ?>
        <li>
          <a href="<?php echo esc_url( home_url( '/' ) . $term->taxonomy . '/' . $term->slug); ?>">
            <div class="product-image">

                <img src="<?php echo esc_url( home_url( '/' ) . 'wp-content/themes/cosmetic/img/'. $term->slug . '.svg' ); ?>">

            </div>
            <div class="product-name">
              <?php echo $term->name; ?>
            </div>
          </a>

        </li>

      <?php endif; ?>
    <?php endforeach; ?>
  </ul>

</div>
