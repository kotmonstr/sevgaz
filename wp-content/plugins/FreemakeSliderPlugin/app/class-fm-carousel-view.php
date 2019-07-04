<?php 

require_once 'class-fm-carousel-list-table.php';
require_once 'class-fm-carousel-creator.php';

class FM_Carousel_View {

	private $controller;
	private $list_table;
	private $creator;
	
	function __construct($controller) {
		
		$this->controller = $controller;
	}
	
	function add_metaboxes() {
		add_meta_box('overview_features', __('Freemake Slider Plugin Features', 'fm_carousel'), array($this, 'show_features'), 'fm_carousel_overview', 'features', '');
		add_meta_box('overview_upgrade', __('Updates', 'fm_carousel'), array($this, 'show_upgrade_to_commercial'), 'fm_carousel_overview', 'upgrade', '');
		add_meta_box('overview_contact', __('Help', 'fm_carousel'), array($this, 'show_contact'), 'fm_carousel_overview', 'contact', '');
	}
	
	function show_upgrade_to_commercial() {
		?>
		<ul class="fm-feature-list">
		</ul>
		<?php
	}
	
	function show_features() {
		?>
		<ul class="fm-feature-list">
			<li>Supported multimedia types: images, video, YouTube, Vimeo, WebM, MP4</li>
			<li>Works on all devices and in all browsers</li>
			<li>Mobile friendly</li>
			<li>LightBox gallery support included</li>
			<li>Easy to manage and use</li>
			<li>Unlimited use within one page or site</li>
			<li>Absolutely free</li>
		</ul>
		<?php
	}
	
	function show_contact() {
		?>
		<p>For any information regarding Freemake Slider Plugin, please don't hesitate to contact support.freemake.com.</p> 
		<?php
	}
	
	function print_overview() {
		
		?>
		<div class="wrap">
		<div id="icon-fm-carousel" class="icon32"><br /></div>
		<div id="wondercarousellightbox_options" data-skinsfoldername=""  data-jsfolder="<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" style="display:none;"></div>
			
		<h2><?php echo __( 'Freemake Slider Plugin', 'fm_carousel' ) . " " . FM_CAROUSEL_VERSION; ?> </h2>
		 
		<div id="welcome-panel" class="welcome-panel">
			<div class="welcome-panel-content">
				<h3>WordPress Freemake Slider Plugin</h3>
				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
						<h4>Start using now</h4>
						<a class="button button-primary button-hero" href="<?php echo admin_url('admin.php?page=fm_carousel_add_new'); ?>">Add a new Slider</a>
					</div>
					<div class="welcome-panel-column welcome-panel-last">
						<h4>Settings</h4>
						<ul>
							<li><a href="<?php echo admin_url('admin.php?page=fm_carousel_show_items'); ?>" class="welcome-icon welcome-widgets-menus">Manage Sliders</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		<div id="dashboard-widgets-wrap">
			<div id="dashboard-widgets" class="metabox-holder columns-2">
	 
	                 <div class="postbox-container">
	                    <?php 
	                    do_meta_boxes( 'fm_carousel_overview', 'features', '' ); 
	                    do_meta_boxes( 'fm_carousel_overview', 'contact', '' ); 
	                    ?>
	                </div>
	 
	                <div class="postbox-container">
	                    <?php 
	                    if (FM_CAROUSEL_VERSION_TYPE != "C")
	                    	do_meta_boxes( 'fm_carousel_overview', 'upgrade', ''); 
	                    do_meta_boxes( 'fm_carousel_overview', 'news', ''); 
	                    ?>
	                </div>
	 
	        </div>
        </div>
            
		<?php
	}
	
	function print_edit_settings() {
		
		?>
		<div class="wrap">
		<div id="icon-fm-carousel" class="icon32"><br /></div>
			
		<h2><?php _e( 'Settings', 'fm_carousel' ); ?> </h2>
		<?php

		if ( isset($_POST['save-carousel-options']) && check_admin_referer('fm-carousel', 'fm-carousel-settings') )
		{		
			unset($_POST['save-carousel-options']);
			
			$this->controller->save_settings($_POST);
			
			echo '<div class="updated"><p>Settings saved.</p></div>';
		}
		
		$settings = $this->controller->get_settings();		
		$userrole = $settings['userrole'];
		$thumbnailsize = $settings['thumbnailsize'];
		$keepdata = $settings['keepdata'];
		$disableupdate = $settings['disableupdate'];
		$supportwidget = $settings['supportwidget'];
		$addjstofooter = $settings['addjstofooter'];
		$jsonstripcslash = $settings['jsonstripcslash'];
		
		?>
		
		<h3>This page is only available for users of Administrator role.</h3>
		
        <form method="post">
        
        <?php wp_nonce_field('fm-carousel', 'fm-carousel-settings'); ?>
        
        <table class="form-table">
        
        <tr valign="top">
			<th scope="row">Set minimum user role</th>
			<td>
				<select name="userrole">
				  <option value="Administrator" <?php echo ($userrole == 'manage_options') ? 'selected="selected"' : ''; ?>>Administrator</option>
				  <option value="Editor" <?php echo ($userrole == 'moderate_comments') ? 'selected="selected"' : ''; ?>>Editor</option>
				  <option value="Author" <?php echo ($userrole == 'upload_files') ? 'selected="selected"' : ''; ?>>Author</option>
				</select>
			</td>
		</tr>
		
		<tr valign="top">
			<th scope="row">Select the default image size from Media Library for slider</th>
			<td>
				<select name="thumbnailsize">
				  <option value="thumbnail" <?php echo ($thumbnailsize == 'thumbnail') ? 'selected="selected"' : ''; ?>>Thumbnail size</option>
				  <option value="medium" <?php echo ($thumbnailsize == 'medium') ? 'selected="selected"' : ''; ?>>Medium size</option>
				  <option value="large" <?php echo ($thumbnailsize == 'large') ? 'selected="selected"' : ''; ?>>Large size</option>
				  <option value="full" <?php echo ($thumbnailsize == 'full') ? 'selected="selected"' : ''; ?>>Full size</option>
				</select>
			</td>
		</tr>
		
		<tr>
			<th>Data option</th>
			<td><label><input name='keepdata' type='checkbox' id='keepdata' <?php echo ($keepdata == 1) ? 'checked' : ''; ?> /> Keep data when deleting the plugin</label>
			</td>
		</tr>
		
		<tr>
			<th>Update option</th>
			<td><label><input name='disableupdate' type='checkbox' id='disableupdate' <?php echo ($disableupdate == 1) ? 'checked' : ''; ?> /> Disable plugin version check and update</label>
			</td>
		</tr>
		
		<tr>
			<th>Display carousel in widget</th>
			<td><label><input name='supportwidget' type='checkbox' id='supportwidget' <?php echo ($supportwidget == 1) ? 'checked' : ''; ?> /> Support shortcode in text widget</label>
			</td>
		</tr>
		
		<tr>
			<th>Scripts position</th>
			<td><label><input name='addjstofooter' type='checkbox' id='addjstofooter' <?php echo ($addjstofooter == 1) ? 'checked' : ''; ?> /> Add plugin js scripts to the footer (wp_footer hook must be implemented by the WordPress theme)</label>
			</td>
		</tr>
		
		<tr>
			<th>JSON options</th>
			<td><label><input name='jsonstripcslash' type='checkbox' id='jsonstripcslash' <?php echo ($jsonstripcslash == 1) ? 'checked' : ''; ?> /> Remove backslashes in JSON string</label>
			</td>
		</tr>
					
        </table>
        
        <p class="submit"><input type="submit" name="save-carousel-options" id="save-carousel-options" class="button button-primary" value="Save Changes"  /></p>
        
        </form>
        
		</div>
		<?php
	}
		
	function print_register() {
		?>
		<div class="wrap">
		<div id="icon-fm-carousel" class="icon32"><br /></div>
			
		<h2><?php _e( 'Register', 'fm_carousel' ); ?></h2>
		<?php
				
		if (isset($_POST['save-carousel-license']) && check_admin_referer('fm-carousel', 'fm-carousel-register') )
		{		
			unset($_POST['save-carousel-license']);

			$ret = $this->controller->check_license($_POST);
			
			if ($ret['status'] == 'valid')
				echo '<div class="updated"><p>The key has been saved.</p></div>';
			else if ($ret['status'] == 'expired')
				echo '<div class="error"><p>Your free upgrade period has expired, please renew your license.</p></div>';
			else if ($ret['status'] == 'invalid')
				echo '<div class="error"><p>The key is invalid.</p></div>';
			else if ($ret['status'] == 'abnormal')
				echo '<div class="error"><p>You have reached the maximum website limit of your license key. Please log into the membership area and upgrade to a higher license.</p></div>';
			else if ($ret['status'] == 'misuse')
				echo '<div class="error"><p>There is a possible misuse of your license key, please contact support@remove.me.please for more information.</p></div>';
			else if ($ret['status'] == 'timeout')
				echo '<div class="error"><p>The license server can not be reached, please try again later.</p></div>';
			else if ($ret['status'] == 'empty')
				echo '<div class="error"><p>Please enter your license key.</p></div>';
			else if (isset($ret['message']))
				echo '<div class="error"><p>' . $ret['message'] . '</p></div>';
		}
		else if (isset($_POST['deregister-carousel-license']) && check_admin_referer('fm-carousel', 'fm-carousel-register') )
		{	
			$ret = $this->controller->deregister_license($_POST);
			
			if ($ret['status'] == 'success')
				echo '<div class="updated"><p>The key has been deregistered.</p></div>';
			else if ($ret['status'] == 'timeout')
				echo '<div class="error"><p>The license server can not be reached, please try again later.</p></div>';
			else if ($ret['status'] == 'empty')
				echo '<div class="error"><p>The license key is empty.</p></div>';
		}
		
		$settings = $this->controller->get_settings();
		$disableupdate = $settings['disableupdate'];
		
		$key = '';
		$info = $this->controller->get_plugin_info();
		if (!empty($info->key) && ($info->key_status == 'valid' || $info->key_status == 'expired'))
			$key = $info->key;
		
		?>
		
		<?php 
		if ($disableupdate == 1)
		{
			echo "<h3 style='padding-left:10px;'>The plugin version check and update is currently disabled. You can enable it in the Settings menu.</h3>";
		}
		else
		{
		?> <div style="padding-left:10px;padding-top:12px;"> <?php
			if (empty($key)) { ?>
				<form method="post">
				<?php wp_nonce_field('fm-carousel', 'fm-carousel-register'); ?>
				<table class="form-table">
				<tr>
					<th>Enter Your License Key:</th>
					<td><input name="fm-carousel-key" type="text" id="fm-carousel-key" value="" class="regular-text" /> <input type="submit" name="save-carousel-license" id="save-carousel-license" class="button button-primary" value="Register License Key"  />
					</td>
				</tr>
				</table>
				</form>
			<?php } else { ?>
				<form method="post">
				<?php wp_nonce_field('fm-carousel', 'fm-carousel-register'); ?>
				<p>You have entered your license key and this domain has been successfully registered. &nbsp;&nbsp;<input name="fm-carousel-key" type="hidden" id="fm-carousel-key" value="<?php echo esc_html($key); ?>" class="regular-text" /><input type="submit" name="deregister-carousel-license" id="deregister-carousel-license" class="button button-primary" value="Deregister Your License Key"  /></p>
				</form>
				<?php if ($info->key_status == 'expired') { ?>
				<p><strong>Your free upgrade period has expired.</strong> To get upgrades, please <a href="https://www.remove.me.please/renew/" target="_blank">renew your license</a>.</p>
				<?php } ?>
			<?php } ?>
			</div>
		<?php } ?>
		
		<div style="padding-left:10px;padding-top:30px;">
		<a href="<?php echo admin_url('update-core.php?force-check=1'); ?>"><button class="button-primary">Force WordPress To Check For Plugin Updates</button></a>
		</div>
					
		<div style="padding-left:10px;padding-top:20px;">
        <ul style="list-style-type:square;font-size:16px;line-height:28px;margin-left:24px;">
		<li><a href="https://www.remove.me.please/how-to-upgrade-a-commercial-version-plugin-to-the-latest-version/" target="_blank">How to upgrade to the latest version</a></li>
	    <li><a href="https://www.remove.me.please/register-faq/" target="_blank">Where can I find my license key and other frequently asked questions</a></li>
	    </ul>
        </div>
        
		</div>
		
		<?php
	}
		
	function print_items() {
		
		?>
		<div class="wrap">
		<div id="icon-fm-carousel" class="icon32"><br /></div>
		<div id="wondercarousellightbox_options" data-skinsfoldername=""  data-jsfolder="<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" style="display:none;"></div>
			
		<h2><?php _e( 'Manage Sliders', 'fm_carousel' ); ?> <a href="<?php echo admin_url('admin.php?page=fm_carousel_add_new'); ?>" class="add-new-h2"> <?php _e( 'New Slider', 'fm_carousel' ); ?></a> </h2>
				
		<form id="carousel-list-table" method="post">
		<input type="hidden" name="page" value="<?php echo esc_html($_REQUEST['page']); ?>" />
		<?php 
		
		if ( !is_object($this->list_table) )
			$this->list_table = new FM_Carousel_List_Table($this);
		
		$this->process_actions();
		
		$this->list_table->list_data = $this->controller->get_list_data();
		$this->list_table->prepare_items();
		$this->list_table->views();
		$this->list_table->display();		
		?>								
        </form>
        
		</div>
		<?php
	}
	
	function print_item()
	{
		if ( !isset( $_REQUEST['itemid'] ) || !is_numeric( $_REQUEST['itemid'] ) )
			return;
		
		?>
		<div class="wrap">
		<div id="icon-fm-carousel" class="icon32"><br /></div>
		<div id="wondercarousellightbox_options" data-skinsfoldername=""  data-jsfolder="<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" style="display:none;"></div>
					
		<h2><?php _e( 'View Slider', 'fm_carousel' ); ?> <a href="<?php echo admin_url('admin.php?page=fm_carousel_edit_item') . '&itemid=' . $_REQUEST['itemid']; ?>" class="add-new-h2"> <?php _e( 'Edit Slider', 'fm_carousel' ); ?>  </a> </h2>
		
		<div class="updated"><p style="text-align:center;">  <?php _e( 'To embed the carousel into your page, use shortcode: ', 'fm_carousel' ); ?> <?php echo esc_attr('[fm_carousel id="' . $_REQUEST['itemid'] . '"]'); ?></p></div>

		<div class="updated"><p style="text-align:center;">  <?php _e( 'To embed the carousel into your template, use php code: ', 'fm_carousel' ); ?> <?php echo esc_attr('<?php echo do_shortcode(\'[fm_carousel id="' . $_REQUEST['itemid'] . '"]\'); ?>'); ?></p></div>
		
		<?php 
			echo $this->controller->generate_body_code( $_REQUEST['itemid'], true ); 
		?>	 
		
		</div>
		<?php
	}
	
	function process_actions()
	{
		if (!isset($_REQUEST['_wpnonce']) || (!wp_verify_nonce( $_REQUEST['_wpnonce'], 'bulk-' . $this->list_table->_args['plural']) && !wp_verify_nonce($_REQUEST['_wpnonce'], 'fm-list-table-nonce')))
			return;
			
		if ( ((isset($_REQUEST['action']) && ($_REQUEST['action'] == 'trash')) || (isset($_REQUEST['action2']) && ($_REQUEST['action2'] == 'trash'))) && isset( $_REQUEST['itemid'] ) )
		{
			$trashed = 0;
	
			if ( is_array( $_REQUEST['itemid'] ) )
			{
				foreach( $_REQUEST['itemid'] as $id)
				{
					if ( is_numeric($id) )
					{
						$ret = $this->controller->trash_item($id);
						if ($ret > 0)
							$trashed += $ret;
					}
				}
			}
			else if ( is_numeric($_REQUEST['itemid']) )
			{
				$trashed = $this->controller->trash_item( $_REQUEST['itemid'] );
			}
	
			if ($trashed > 0)
			{
				echo '<div class="updated"><p>';
				printf( _n('%d slider moved to the trash.', '%d sliderss moved to the trash.', $trashed), $trashed );
				echo '</p></div>';
			}
		}
	
		if ( ((isset($_REQUEST['action']) && ($_REQUEST['action'] == 'restore')) || (isset($_REQUEST['action2']) && ($_REQUEST['action2'] == 'restore'))) && isset( $_REQUEST['itemid'] ) )
		{
			$restored = 0;
	
			if ( is_array( $_REQUEST['itemid'] ) )
			{
				foreach( $_REQUEST['itemid'] as $id)
				{
					if ( is_numeric($id) )
					{
						$ret = $this->controller->restore_item($id);
						if ($ret > 0)
							$restored += $ret;
					}
				}
			}
			else if ( is_numeric($_REQUEST['itemid']) )
			{
				$restored = $this->controller->restore_item( $_REQUEST['itemid'] );
			}
	
			if ($restored > 0)
			{
				echo '<div class="updated"><p>';
				printf( _n('%d slider restored.', '%d sliders restored.', $restored), $restored );
				echo '</p></div>';
			}
		}
	
		if ( ((isset($_REQUEST['action']) && ($_REQUEST['action'] == 'delete')) || (isset($_REQUEST['action2']) && ($_REQUEST['action2'] == 'delete'))) && isset( $_REQUEST['itemid'] ) )
		{
			$deleted = 0;
				
			if ( is_array( $_REQUEST['itemid'] ) )
			{
				foreach( $_REQUEST['itemid'] as $id)
				{
					if ( is_numeric($id) )
					{
						$ret = $this->controller->delete_item($id);
						if ($ret > 0)
							$deleted += $ret;
					}
				}
			}
			else if ( is_numeric($_REQUEST['itemid']) )
			{
				$deleted = $this->controller->delete_item( $_REQUEST['itemid'] );
			}
				
			if ($deleted > 0)
			{
				echo '<div class="updated"><p>';
				printf( _n('%d slider deleted.', '%d sliders deleted.', $deleted), $deleted );
				echo '</p></div>';
			}
		}
	
		if ( ((isset($_REQUEST['action']) && ($_REQUEST['action'] == 'clone')) || (isset($_REQUEST['action2']) && ($_REQUEST['action2'] == 'clone'))) && isset( $_REQUEST['itemid'] ) && is_numeric( $_REQUEST['itemid'] ))
		{
			$cloned_id = $this->controller->clone_item( $_REQUEST['itemid'] );
			if ($cloned_id > 0)
			{
				echo '<div class="updated"><p>';
				printf( 'New carousel created with ID: %d', $cloned_id );
				echo '</p></div>';
			}
			else
			{
				echo '<div class="error"><p>';
				printf( 'The carousel cannot be cloned.' );
				echo '</p></div>';
			}
		}
	}

	function print_add_new() {
		
		if ( !empty($_POST['fm-carousel-save-item-post-value']) && !empty($_POST['fm-carousel-save-item-post']) && check_admin_referer('fm-carousel', 'fm-carousel-saveform'))
		{
			$this->save_item_post($_POST['fm-carousel-save-item-post-value']);
			return;
		}
		
		?>
		<div class="wrap">
		<div id="icon-fm-carousel" class="icon32"><br /></div>
		<div id="wondercarousellightbox_options" data-skinsfoldername=""  data-jsfolder="<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" style="display:none;"></div>
		
		<h2><?php _e( 'New Slider', 'fm_carousel' ); ?> <a href="<?php echo admin_url('admin.php?page=fm_carousel_show_items'); ?>" class="add-new-h2"> <?php _e( 'Manage sliders', 'fm_carousel' ); ?>  </a> </h2>
		
		<?php 
		$this->creator = new FM_Carousel_Creator($this);		
		
		$settings = $this->controller->get_settings();
		echo $this->creator->render( -1, null, $settings['thumbnailsize'] );
	}
	
	function print_edit_item()
	{

		if ( !empty($_POST['fm-carousel-save-item-post-value']) && !empty($_POST['fm-carousel-save-item-post']) && check_admin_referer('fm-carousel', 'fm-carousel-saveform'))
		{
			$this->save_item_post($_POST['fm-carousel-save-item-post-value']);
			return;
		}
		
		if ( !isset( $_REQUEST['itemid'] ) || !is_numeric( $_REQUEST['itemid'] ) )
			return;
	
		?>
		<div class="wrap">
		<div id="icon-fm-carousel" class="icon32"><br /></div>
		<div id="wondercarousellightbox_options" data-skinsfoldername=""  data-jsfolder="<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" style="display:none;"></div>
			
		<h2><?php _e( 'Edit Slider', 'fm_carousel' ); ?> <a href="<?php echo admin_url('admin.php?page=fm_carousel_show_item') . '&itemid=' . $_REQUEST['itemid']; ?>" class="add-new-h2"> <?php _e( 'View Slider', 'fm_carousel' ); ?>  </a> </h2>
		
		<?php 
		$this->creator = new FM_Carousel_Creator($this);
		$settings = $this->controller->get_settings();
		echo $this->creator->render( $_REQUEST['itemid'], $this->controller->get_item_data( $_REQUEST['itemid'] ), $settings['thumbnailsize'] );
	}
	
	function save_item_post($item_post) {
			
		$jsonstripcslash = get_option( 'fm_carousel_jsonstripcslash', 1 );
		if ($jsonstripcslash == 1)
			$json_post = trim(stripcslashes($item_post));
		else
			$json_post = trim($item_post);
		$json_post = str_replace("\\\\", "\\\\\\\\", $json_post);
		$items = json_decode($json_post, true);
				
		if ( empty($items) )
		{
			$json_error = "json_decode error";
			if ( function_exists('json_last_error_msg') )
				$json_error .= ' - ' . json_last_error_msg();
			else if ( function_exists('json_last_error') )
				$json_error .= 'code - ' . json_last_error();
				
			$ret = array(
					"success" => false,
					"id" => -1,
					"message" => $json_error . ". <b>To fix the problem, in the Plugin Settings menu, please uncheck the option Remove backslashes in JSON string and try again.</b>",
					"errorcontent"	=> $json_post
			);
		}
		else
		{
			foreach ($items as $key => &$value)
			{
				if ($value === true)
					$value = "true";
				else if ($value === false)
					$value = "false";
				else if ( is_string($value) )
					$value = wp_kses_post($value);
			}
		
			if (isset($items["slides"]) && count($items["slides"]) > 0)
			{
				foreach ($items["slides"] as $key => &$slide)
				{
					foreach ($slide as $key => &$value)
					{
						if ($value === true)
							$value = "true";
						else if ($value === false)
							$value = "false";
						else if ( is_string($value) )
							$value = wp_kses_post($value);
					}
				}
			}
		
			$ret = $this->controller->save_item($items);
		}
		?>
				
		<div class="wrap">
		<div id="icon-fm-carousel" class="icon32"><br /></div>
		
		<?php 
		if (isset($ret['success']) && $ret['success'] && isset($ret['id']) && $ret['id'] >= 0) 
		{
			echo "<h2>Slider Saved.";
			echo "<a href='" . admin_url('admin.php?page=fm_carousel_edit_item') . '&itemid=' . $ret['id'] . "' class='add-new-h2'>Edit Slider</a>";
			echo "<a href='" . admin_url('admin.php?page=fm_carousel_show_item') . '&itemid=' . $ret['id'] . "' class='add-new-h2'>View Slider</a>";
			echo "</h2>";
					
			echo "<div class='updated'><p>The carousel has been saved and published.</p></div>";
			echo "<div class='updated'><p>To embed the carousel into your page or post, use shortcode:  [fm_carousel id=\"" . $ret['id'] . "\"]</p></div>";
			echo "<div class='updated'><p>To embed the carousel into your template, use php code:  &lt;?php echo do_shortcode('[fm_carousel id=\"" . $ret['id'] . "\"]'); ?&gt;</p></div>"; 
		}
		else
		{
			echo "<h2>Freemake Slider</h2>";
			echo "<div class='error'><p>The slider can not be saved.</p></div>";
			echo "<div class='error'><p>Error Message: " . ((isset($ret['message'])) ? $ret['message'] : "") . "</p></div>";
			echo "<div class='error'><p>Error Content: " . ((isset($ret['errorcontent'])) ? $ret['errorcontent'] : "") . "</p></div>";
		}	
	}
		
}