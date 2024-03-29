<?php
add_action( 'widgets_init', 'rambo_widgets_init');
function rambo_widgets_init() {
$rambo_pro_theme_options = theme_data_setup();
$current_options = wp_parse_args(  get_option( 'rambo_pro_theme_options', array() ), $rambo_pro_theme_options );
$site_intro_column_layout = 12 / $current_options['site_intro_column_layout'];
$service_column_layout = 12 / $current_options['service_column_layout'];
$project_column_layout = 12 / $current_options['project_column_layout'];

/*sidebar*/
register_sidebar( array(
		'name' => __('Sidebar widget area', 'rambo' ),
		'id' => 'sidebar-primary',
		'description' => __('Sidebar widget area', 'rambo' ),
		'before_widget' => '<div class="sidebar_widget widget %2$s" >',
		'after_widget' => '</div>',
		'before_title' => '<div class="red-line"></div><div class="caption-tile-about"><p class="caption-text">',
		'after_title' => '</p></div>',
	) );


//Site Intro Top
register_sidebar( array(
		'name' => __('Call to action top widget area', 'rambo' ),
		'id' => 'site-intro-area',
		'description' => __('Call to action top widget area', 'rambo' ),
		'before_widget' => '<div id="%1$s" class="span'.$site_intro_column_layout.' widget %2$s">',
		'after_widget' => '</div>',
    'before_title' => '<div class="red-line"></div><div class="caption-tile-about"><p class="caption-text">',
    'after_title' => '</p></div>',
	) );

// Service Widget Sidebar
	register_sidebar( array(
		'name' => __('Homepage service section - sidebar', 'rambo' ),
		'id' => 'sidebar-service',
		'description' => __('Use the widget Page/Service Widget to add service type content','rambo'),
		'before_widget' => '<div id="%1$s" class="span'.$service_column_layout.' home_service widget %2$s">',
		'after_widget' => '</div>',
        'before_title' => '<div class="red-line"></div><div class="caption-tile-about"><p class="caption-text">',
        'after_title' => '</p></div>',
	) );


//Project Sidebar
	register_sidebar( array(
			'name' => __( 'Homepage project section - sidebar', 'rambo' ),
			'id' => 'sidebar-project',
			'description' => __('Use the Project Widget to add project type content','rambo'),
			'before_widget' => '<div id="%1$s" class="span'.$project_column_layout.' featured_port_projects widget %2$s">',
			'after_widget' => '</div>',
        'before_title' => '<div class="red-line"></div><div class="caption-tile-about"><p class="caption-text">',
        'after_title' => '</p></div>',
		) );

register_sidebar( array(
	'name' => __('Woocommerce sidebar widget area', 'rambo' ),
	'id' => 'woocommerce',
	'description' => __( 'Woocommerce sidebar widget area', 'rambo' ),
	'before_widget' => '<div class="sidebar-widget" >',
	'after_widget' => '</div>',
    'before_title' => '<div class="red-line"></div><div class="caption-tile-about"><p class="caption-text">',
    'after_title' => '</p></div>',
	) );


//Footer Sidebar
register_sidebar( array(
		'name' => __('Footer widget area', 'rambo' ),
		'id' => 'footer-widget-area',
		'description' => __('Footer widget area', 'rambo' ),
		'before_widget' => '<div class="span4 footer_widget widget %2$s">',
		'after_widget' => '</div>',
    'before_title' => '<div class="red-line"></div><div class="caption-tile-about"><p class="caption-text">',
    'after_title' => '</p></div>',
	) );

	//Footer social Sidebar
register_sidebar( array(
		'name' => __('Footer social icon sidebar area', 'rambo' ),
		'id' => 'footer-social-icon-sidebar-area',
		'description' => __('Footer social icon sidebar area', 'rambo' ),
		'before_widget' => '<div id="%1$s"  class="pull-right %2$s">',
		'after_widget' => '</div>',
    'before_title' => '<div class="red-line"></div><div class="caption-tile-about"><p class="caption-text">',
    'after_title' => '</p></div>',
	) );

}
?>