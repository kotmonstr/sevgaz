<?php
$temp = $wp_query; $wp_query= null;
//$wp_query = new WP_Query(); $wp_query->query('showposts=30&post_type=page&post_parent=1379');  // локал
$wp_query = new WP_Query(); $wp_query->query('showposts=30&post_type=page&post_parent=1438'); // прод
?>

<div class="row">
    <div class="span12">
        <div class="red-line"></div>
        <div class="caption-tile-about">
            <p class="caption-text">ПОТРЕБИТЕЛЯМ</p>
            <div id="sidebar-project" class="row sidebar-project">

                <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

                    <div id="" class="span4 featured_port_projects widget widget_rambo_feature_page_widget">
                        <a href="<?php the_permalink(); ?>">
                            <div class="featured-service-img">
                                <?php  echo the_post_thumbnail('large'); ?>
                            </div>
                        </a>
                        <h2 class="widget-title">
                           <?php  echo the_title(); ?>
                        </h2>
                    </div>

                <?php endwhile; ?>

        </div>
    </div>
</div>
</div>



<?php
$temp = $wp_query; $wp_query= null;
$wp_query = new WP_Query(); $wp_query->query('showposts=30&category_name=uslugi');
?>

<div class="row">
    <div class="span12">
        <div class="red-line"></div>
        <div class="caption-tile-about">
            <p class="caption-text">ПОПУЛЯРНОЕ</p>
            <div id="sidebar-project" class="row sidebar-project">

                <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

                    <div id="" class="span4 featured_port_projects widget widget_rambo_feature_page_widget">
                        <a href="<?php the_permalink(); ?>">
                            <div class="featured-service-img">
                                <?php  echo the_post_thumbnail('large'); ?>
                            </div>
                        </a>
                        <h2 class="widget-title">
                            <?php  echo the_title(); ?>
                        </h2>
                    </div>

                <?php endwhile; ?>

            </div>
        </div>
    </div>
</div>