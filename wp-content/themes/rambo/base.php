<?php //Template Name:Base ?>
<?php get_template_part('banner','strip');?>
<!-- Container -->
<div class="portfolio_main_content">
    <div class="container">

        <div class="row-fluid featured_port_title">
            <h1><?php  the_title(); ?></h1>
        </div>
        <!-- Blog Section Content -->
        <div class="row-fluid">
            <!-- Blog Single Page -->
            <div class="Blog_main">
                <div class="blog_single_post" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php  the_post(); ?>
                <?php  the_content(  ); ?>
                </div>
            </div>
        </div>
	</div>
</div>
<?php get_footer();?>