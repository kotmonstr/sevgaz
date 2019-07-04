<?php
/*
    Template Name: Main-page
*/
?>
<?php get_header(); ?>

    <div style="display: flex;flex-wrap: wrap;">

    <article style="flex: 1 1 50%; min-width: 350px; margin-top: 20px;">
        <h2><img src="<?php echo get_template_directory_uri() ?>/assets/images/flag.png" height="50" width="50">НОВОСТИ</h2>

        <?php // Display blog posts on any page @ http://m0n.co/l
        $temp = $wp_query; $wp_query= null;
        $wp_query = new WP_Query(); $wp_query->query('showposts=7' . '&paged='.$paged . '&category_name=news'. '&order=DESC'. '&post_status=publish');
        while ($wp_query->have_posts()) : $wp_query->the_post(); ?>


            <div class="flex-o-main">
                <div class="image-thumb">
                    <?php the_post_thumbnail('medium') ?>
                </div>
                <div class="flex-o-main-info" >
                    <div class="flex-o-main-title"><a href="<?php the_permalink(); ?>" title="Read more"><?php the_title(); ?></a></div>
                    <div class="flex-o-main-name">
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            </div>

            <?php endwhile; ?>


        <?php wp_reset_postdata(); ?>

    </article>

    <article  style="flex: 1 1 50%; min-width: 350px; margin-top: 20px;">
        <h2><img src="<?php echo get_template_directory_uri() ?>/assets/images/flag.png" height="50" width="50">АНОНСЫ</h2>

        <?php // Display blog posts on any page @ http://m0n.co/l
        $temp = $wp_query; $wp_query= null;
        $wp_query = new WP_Query(); $wp_query->query('showposts=7' . '&paged='.$paged . '&category_name=anonce'. '&order=DESC');
        while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

            <div class="flex-o-main">
                <div class="image-thumb">
                    <?php the_post_thumbnail('medium') ?>
                </div>
                <div class="flex-o-main-info">
                    <div class="flex-o-main-title"><a href="<?php the_permalink(); ?>" title="Read more"><?php the_title(); ?></a></div>
                    <div class="flex-o-main-name">
                        <?php the_excerpt(); ?>
                    </div>
                </div>
            </div>

                <?php endwhile; ?>


        <?php wp_reset_postdata(); ?>

    </article>
    </div>
<?php get_footer(); ?>