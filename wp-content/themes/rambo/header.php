<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head> 
	<meta http-equiv="X-UA-Compatible" content="IE=9">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>" charset="<?php bloginfo('charset'); ?>" />
	<meta name="generator" content="WordPress <?php bloginfo('version'); ?>"/>
	<?php 
	$rambo_pro_theme_options = theme_data_setup();
	$rambopro_current_options = wp_parse_args(  get_option( 'rambo_pro_theme_options', array() ), $rambo_pro_theme_options );
	?>	
	<?php $rambo_css="default.css";?>
	<link rel="stylesheet" href="<?php echo WEBRITI_TEMPLATE_DIR_URI; ?>/css/<?php echo $rambo_css; ?>" type="text/css" media="screen" />
	<?php 		
		if($rambopro_current_options['upload_image_favicon']!='')
		{ ?><link rel="shortcut icon" href="<?php  echo $rambopro_current_options['upload_image_favicon']; ?>" /> 
			<?php } else {?>	
			<link   rel="shortcut icon" href="<?php echo get_template_directory_uri();?>/images/fevicon.icon">
		<?php } 
		wp_head(''); ?>
</head>
<body <?php body_class(); ?> >
<div class="content-body">
<div class="visually-bl"><?php echo do_shortcode( ' [FTVI]' ); ?></div>

<div class="container container-mb">
		<div class="navbar">
            <div class="navbar-inner">
                <div class="">
                  <a data-target=".navbar-responsive-collapse" data-toggle="collapse" class="btn btn-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>

				  <?php $blogname = get_bloginfo( );
						$blogname1 = substr($blogname,0,1);
						$blogname2 = substr($blogname,1);
				  ?>

                   <div class="header-flex-top">
                       <div class="flex-line-one">
                          <a href="<?php echo home_url( '/' ); ?>" class="brand">
                              <img src="<?php echo get_template_directory_uri();?>/alvion/images/logo.png" alt="logo" style="height: 58px;text-align: left;float: left;margin-right: 10px">
                              <span class="logo-title"><?php echo ucfirst($blogname1); ?><?php echo $blogname2; ?></span>
                          </a>
                       </div>
                       <div class="flex-line-two">
                           <form role="search" method="get" id="searchform" class="searchform" action="/">
                               <div>
                                   <label class="screen-reader-text" for="s">Search for:</label>
                                   <input type="text" value="" name="s" id="s" />
                                   <i class="fa fa-search" onclick="jQuery('#searchform').submit()" ></i>
                               </div>
                           </form>
                       </div>
                       <div class="flex-line-tree">
                            <p>Единый контактный центр<br>
                            +7(978)082-62-32</p>
                       </div>
                   </div>


                </div>
            </div><!-- /navbar-inner -->
        </div>
</div>

<div class="nav-collapse collapse navbar-responsive-collapse" id="line-menu">
    <?php	wp_nav_menu( array(
            'theme_location' => 'primary',
            'container'  => 'nav-collapse collapse navbar-inverse-collapse',
            'menu_class' => 'nav nav-new',
            'fallback_cb' => 'webriti_fallback_page_menu',
            'walker' => new webriti_nav_walker()
        )
    );	?>
</div><!-- /.nav-collapse -->