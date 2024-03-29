<?php
/**
* @Theme Name	:	Rambopro
* @file         :	index-project.php
* @package      :	Busiprof
* @author       :	Hari Maliya
* @license      :	license.txt
* @filesource   :	wp-content/themes/rambopro/index-project.php
*/
$rambo_pro_theme_options = theme_data_setup();
$current_options = wp_parse_args(  get_option( 'rambo_pro_theme_options', array() ), $rambo_pro_theme_options );
if($current_options['project_protfolio_enabled']==false)
{
?>
<!-- Recent Work Section -->
<div class="portfolio_main_content">
	<div class="container">
	<?php
	$rambo_pro_theme_options = theme_data_setup();
	$current_options = wp_parse_args(  get_option( 'rambo_pro_theme_options', array() ), $rambo_pro_theme_options );
	?>

		<?php
		if(is_active_sidebar('sidebar-project'))
		{
//			echo '<div id="sidebar-project" class="row sidebar-project">';
//			    dynamic_sidebar('sidebar-project');
//			echo '</div>';
?>


		<?php get_template_part('widget','service'); ?>
            <?php

		}
		else
		{ ?>
				<div id="sidebar-project" class="row">
					<div class="span3 featured_port_projects">
						<div class="thumbnail">
						<?php if($current_options['project_one_thumb']) { ?>
							  <img src="<?php echo $current_options['project_one_thumb']; ?>">
						<?php } ?>

							  <div class="featured_service_content">
								<?php if($current_options['project_one_title']) { ?>
								<h3><a href="#"><?php echo $current_options['project_one_title']; ?></a></h3>
								<?php } ?>
								<?php if($current_options['project_one_text']) { ?>
								<p><?php echo $current_options['project_one_text']; ?></p>
								<?php } ?>
							  </div>
						</div>
					</div>
					<div class="span3 featured_port_projects">
						<div class="thumbnail">
						<?php if($current_options['project_two_thumb']) { ?>
							  <img src="<?php echo $current_options['project_two_thumb']; ?>">
						<?php } ?>

							  <div class="featured_service_content">
								<?php if($current_options['project_two_title']) { ?>
								<h3><a href="#"><?php echo $current_options['project_two_title']; ?></a></h3>
								<?php } ?>
								<?php if($current_options['project_two_text']) { ?>
								<p><?php echo $current_options['project_two_text']; ?></p>
								<?php } ?>
							  </div>
						</div>
					</div>
					<div class="span3 featured_port_projects">
						<div class="thumbnail">
						<?php if($current_options['project_three_thumb']) { ?>
							  <img src="<?php echo $current_options['project_three_thumb']; ?>">
						<?php } ?>

							  <div class="featured_service_content">
								<?php if($current_options['project_three_title']) { ?>
								<h3><a href="#"><?php echo $current_options['project_three_title']; ?></a></h3>
								<?php } ?>
								<?php if($current_options['project_three_text']) { ?>
								<p><?php echo $current_options['project_three_text']; ?></p>
								<?php } ?>
							  </div>
						</div>
					</div>
					<div class="span3 featured_port_projects">
						<div class="thumbnail">
						<?php if($current_options['project_four_thumb']) { ?>
							  <img src="<?php echo $current_options['project_four_thumb']; ?>">
						<?php } ?>

							  <div class="featured_service_content">
								<?php if($current_options['project_four_title']) { ?>
								<h3><a href="#"><?php echo $current_options['project_four_title']; ?></a></h3>
								<?php } ?>
								<?php if($current_options['project_four_text']) { ?>
								<p><?php echo $current_options['project_four_text']; ?></p>
								<?php } ?>
							  </div>
						</div>
					</div>
				</div>
		<?php }
		?>
	</div>
</div>
<?php } ?>


<!--<div class="testimonial-main">-->
<!--    --><?php//// echo do_shortcode( '[sp_wpcarousel id="316"]' ); ?>
<!--</div>-->


