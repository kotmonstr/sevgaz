<!-- Widgets Section -->
<?php
$rambo_pro_theme_options = theme_data_setup();
$current_options = wp_parse_args(  get_option( 'rambo_pro_theme_options', array() ), $rambo_pro_theme_options ); ?>
<?php if ( is_active_sidebar( 'footer-widget-area' ) ){ ?>

    <!-- /Recent Work Section -->


<div class="hero-widgets-section">
	<div class="container" style="padding: 20px 0px 0px 0px">
		<div class="row">
			<?php dynamic_sidebar( 'footer-widget-area' ); ?>			
		</div>
	</div>
</div>
<?php } ?>
<!-- /Widgets Section -->
<?php
$rambo_pro_theme_options = theme_data_setup();
$current_options = wp_parse_args(  get_option( 'rambo_pro_theme_options', array() ), $rambo_pro_theme_options ); ?>

<!-- Footer Section -->
    <div class="footer-section">
	<div class="container">
		<div class="row">
			<div class="span8">
				<?php if( isset( $current_options['footer_copyright'] ) && $current_options['footer_copyright'] != '' ) { ?>
					<p><?php echo $current_options['footer_copyright']; ?></p>	
				<?php } else{ ?> 
				<p><?php _e('Powered By ','rambo');?> <a target="_blank" href="<?php echo esc_url ( 'http://wordpress.org/') ; ?>"> <?php _e('WordPress','rambo');?></a>&nbsp;&nbsp;<?php if($current_options['rambo_designed_by_head']!=''){ echo ($current_options['rambo_designed_by_head']); } ?>
				<?php if(is_home()) {?>
				  <a rel="nofollow" target="_blank" href="<?php if($current_options['rambo_designed_by_link']!='') { echo esc_url($current_options['rambo_designed_by_link']);} ?>"><?php if($current_options['rambo_designed_by_text']!='') { ?>
				  <?php  echo ($current_options['rambo_designed_by_text']); } ?></a>&nbsp;&nbsp;<?php if($current_options['rambo_copy_rights_text']!='') { ?>
				  <?php  echo ($current_options['rambo_copy_rights_text']); } ?>
				  <?php  } else { ?>
				  <?php if($current_options['rambo_designed_by_text']!='') { ?>
				  <?php  echo ($current_options['rambo_designed_by_text']); } ?></a>&nbsp;&nbsp;<?php if($current_options['rambo_copy_rights_text']!='') { ?>
				  <?php  echo ($current_options['rambo_copy_rights_text']); } ?><?php }?>
				</p>
				<?php }?>
			</div>
			<div class="span4">



				<?php

					$rambo_theme_options = theme_data_setup();
					$current_options = wp_parse_args(  get_option( 'rambo_theme_options', array() ), $rambo_theme_options );

					?>
					<div class="footer_social pull-right">
                        <?php echo do_shortcode("[uptolike]"); ?>
				
<!--					<a href="--><?php //echo esc_attr($current_options['social_media_facebook_link']);   ?><!--" class="facebook">&nbsp;</a>-->
<!---->
<!--					<a href="--><?php //echo esc_attr($current_options['social_media_twitter_link']); ?><!--" class="twitter">&nbsp;</a>-->
<!---->
<!--					<a href="--><?php //echo esc_attr($current_options['social_media_linkedin_link']); ?><!--" class="linked-in">&nbsp;</a>-->
<!---->
<!--					<a href="--><?php // echo esc_attr($current_options['social_media_google_plus']); ?><!--" class="google_plus">&nbsp;</a>-->
					
				</div>

			</div>		
		</div>
	</div>		
</div>
<!-- Footer Section-->

<?php
// custom css
if ( version_compare( $GLOBALS['wp_version'], '4.6', '>=' ) ) {
}
else{
	$rambo_pro_theme_options = theme_data_setup();
	$current_options = wp_parse_args(  get_option( 'rambo_pro_theme_options', array() ), $rambo_pro_theme_options );
	if($current_options['webrit_custom_css']!='') {
		echo '<style>'.wp_filter_nohtml_kses($current_options['webrit_custom_css']).'</style>';
	}
}
wp_footer(); ?>
</body>
</html>