<?php
$rambo_pro_theme_options = theme_data_setup();
$current_options = wp_parse_args(  get_option( 'rambo_pro_theme_options', array() ), $rambo_pro_theme_options );
if( $current_options['news_enable'] == false )
{
?>


<div class="container">
			<div id="rambo_recent_news_widget-3" class="rambo_post_section widget widget_rambo_recent_news_widget">
				<div class="row">
					<div class="span12">


                        <div class="red-line"></div>
                        <div class="caption-tile-about">
                            <p class="caption-text">НАШИ НОВОСТИ</p>
                        </div>



					</div>
				</div>
				<div class="row">
				<?php 	$args = array('category_name'=> 'news', 'post_type' => 'post','posts_per_page' => 6,'post__not_in'=>get_option("sticky_posts")) ;
						query_posts( $args );
						if(query_posts( $args ))
					{
						while(have_posts()):the_post();
					{
				?>
			    <div class="span4 latest_news_section">
				<?php $defalt_arg =array('class' => "img-responsive latest_news_img");?>
					<?php if(has_post_thumbnail()){ ?>
						<a href="<?php the_permalink(); ?>" >
						<?php the_post_thumbnail('',$defalt_arg);?></a>
						<?php } ?>
					<h3><a href="<?php the_permalink(); ?>"><?php the_title() ;?></a></h3>
					<p><?php  echo get_the_excerpt(); ?></p>

					<div class="latest_news_comment">
						<a class="pull-left" href="<?php the_permalink(); ?>"><i class="fa fa-calendar icon-spacing"></i><?php the_time('M j,Y');?></a>
						
					</div>
				</div>
					<?php } endwhile; } ?>
				</div>
			</div>



</div>
<?php } ?>
<!-- /Latest News Section -->

