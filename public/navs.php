<?php
/**
 * Created by PhpStorm.
 * User: sbardian
 * Date: 6/14/17
 * Time: 6:57 PM
 */

?>

<div class="container">
    <?php
    $options = get_option('navBoxes-Settings');
    if ($options['title']) { ?>
        <h2><?php echo $options['title']; ?></h2>
    <?php } ?>
    <div class="nav-cards">
    <?php
    $args = array('post_type' => 'navBoxes', 'posts_per_page' => 10, 'order' => 'DESC', 'orderby'=>'date' );
    $the_query = new WP_Query($args);
    if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
        <a class="nav-card" href="#">
            <?php
            $thumb_id = get_post_thumbnail_id();
            $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'full', true);
            $thumb_url = $thumb_url_array[0];
            ?>
            <span class="nav-card-header" style="background-image: url(<?php echo $thumb_url ?>);">
                <span class="nav-card-title" style="background: <?php echo $options['titleBgColor'] ?>; opacity: 0.8;">
                    <h3><?php the_title(); ?></h3>
                </span>
            </span>
          <span class="nav-card-summary">
                    <?php the_content(); ?>
                </span>
          <span class="nav-card-meta">
                    <?php echo get_the_date('F j, Y'); ?>
                </span>
        </a>
    <?php endwhile; ?>
    <?php else : ?>
        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>
    </div>
</div>
