<?php

get_header('second');
//For post
$slider_enable_post = sanitize_text_field( get_post_meta( get_the_ID(), 'slider_enable_post', true ));
if($slider_enable_post == true){
get_template_part('index','slider');
}
?>

<?php my_get_template_part('redline', array('title' => 'НАШИ НОВОСТИ')); ?>

<div class="portfolio_main_content">
    <div class="container" >

	<!-- Blog Section Content -->
	<div class="row-fluid">
		<!-- Blog Main -->
		<div class="<?php if( is_active_sidebar('sidebar-primary')) echo "span12"; else echo "span12";?> Blog_main">
			<?php
				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
				$args = array('category_name'=> 'news', 'post_type' => 'post','paged'=>$paged);
				$post_type_data = new WP_Query( $args );
					while($post_type_data->have_posts()):
					$post_type_data->the_post();
					global $more;
					$more = 0;?>


					<div class="blog_section2" id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <div class="row">

                            <div class="span4">
                                <?php $defalt_arg =array('class' => "img-responsive blog_section2_img" )?>
                                <?php if(has_post_thumbnail()): ?>
                                    <a class="blog_pull_img2" href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('', $defalt_arg); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="span8">
                                <div class="red-line" style=""></div>
                                <div class="caption-tile-about">
                                    <p class="caption-text"><?php  the_title(); ?></p>
                                </div>

                            </div>
                        </div>







                        <?php//  the_content( __('Read More','rambo') ); ?>
                            <a href="<?php echo get_permalink() ?>" class="red-link-fl-right">читать >> </a>
                        <?php $posttags = get_the_tags();?>
                        <?php if ($posttags) { ?>
                        <p class="tags_alignment">
                        <span class="blog_tags"><i class="fa fa-tags"></i><a href="<?php the_permalink(); ?>"><?php the_tags(__('Tags','rambo'));?></a></span>
                        </p>
                        <?php }  wp_link_pages( $args ); ?>
			        </div>
			<?php endwhile; ?>



            <div class="pagination_section">
                <div class="pagination text-center">
                    <ul>
                        <?php $GLOBALS['wp_query']->max_num_pages = $post_type_data->max_num_pages;
                        the_posts_pagination( array(
                            'prev_text'          => '<i class="fa fa-angle-double-left"></i>',
                            'next_text'          => '<i class="fa fa-angle-double-right"></i>',
                        ) ); ?>
                    </ul>
                </div>
            </div>


		</div>
	</div>
</div>
</div>




<?php get_footer();?>