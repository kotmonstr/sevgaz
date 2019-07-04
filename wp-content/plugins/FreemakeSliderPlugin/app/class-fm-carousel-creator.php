<?php

class FM_Carousel_Creator {

	private $parent_view, $list_table;
	
	function __construct($parent) {
		
		$this->parent_view = $parent;
	}
	
	function render( $id, $config, $thumbnailsize ) {
		
		?>
		
		<h3><?php _e( 'General', 'fm_carousel' ); ?></h3>
		
		<div id="fm-carousel-id" style="display:none;"><?php echo $id; ?></div>
		
		<?php 
		$config = str_replace('\\\"', '"', $config);
		$config = str_replace("\\\'", "'", $config);
		$config = str_replace("<", "&lt;", $config);
		$config = str_replace(">", "&gt;", $config);
		$config = str_replace("\\\\", "\\", $config);
		$config = str_replace("&quot;", "", $config);
		?>
		
		<div id="fm-carousel-id-config" style="display:none;"><?php echo $config; ?></div>
		<div id="fm-carousel-pluginfolder" style="display:none;"><?php echo FM_CAROUSEL_URL; ?></div>
		<div id="fm-carousel-jsfolder" style="display:none;"><?php echo FM_CAROUSEL_URL . 'engine/'; ?></div>
		<div id="fm-carousel-viewadminurl" style="display:none;"><?php echo admin_url('admin.php?page=fm_carousel_show_item'); ?></div>
		<div id="fm-carousel-wp-history-media-uploader" style="display:none;"><?php echo ( function_exists("wp_enqueue_media") ? "0" : "1"); ?></div>
		<div id="fm-carousel-thumbnailsize" style="display:none;"><?php echo $thumbnailsize; ?></div>
		<div id="fm-carousel-ajaxnonce" style="display:none;"><?php echo wp_create_nonce( 'fm-carousel-ajaxnonce' ); ?></div>
		<div id="fm-carousel-saveformnonce" style="display:none;"><?php wp_nonce_field('fm-carousel', 'fm-carousel-saveform'); ?></div>
		<?php 
			$cats = get_categories();
			$catlist = array();
			foreach ( $cats as $cat )
			{
				$catlist[] = array(
						'ID' => $cat->cat_ID,
						'cat_name' => $cat ->cat_name
				);
			}
		?>
		<div id="fm-carousel-catlist" style="display:none;"><?php echo json_encode($catlist); ?></div>
			
		<div style="margin:0 12px;">
		<table class="fm-form-table">
			<tr>
				<th><?php _e( 'Name', 'fm_carousel' ); ?></th>
				<td><input name="fm-carousel-name" type="text" id="fm-carousel-name" value="My slider" class="regular-text" /></td>
			</tr>
		</table>
		</div>
		
		<h3><?php _e( 'Steps', 'fm_carousel' ); ?></h3>
		
		<div style="margin:0 12px;">
		<ul class="fm-tab-buttons" id="fm-carousel-toolbar">
			<li class="fm-tab-button step1 fm-tab-buttons-selected"><?php _e( 'Add content', 'fm_carousel' ); ?></li>
			<li class="fm-tab-button step2"><?php _e( 'Choose style', 'fm_carousel' ); ?></li>
			<li class="fm-tab-button step3"><?php _e( 'Adjust', 'fm_carousel' ); ?></li>
			<li class="fm-tab-button step4"><?php _e( 'Preview', 'fm_carousel' ); ?></li>
			<li class="laststep"><input class="button button-primary" type="button" value="<?php _e( 'Save & Publish', 'fm_carousel' ); ?>"></input></li>
		</ul>
				
		<ul class="fm-tabs" id="fm-carousel-tabs">
			<li class="fm-tab fm-tab-selected">	
			
				<div class="fm-toolbar">	
					<input type="button" class="button" id="fm-add-image" value="<?php _e( 'Add Image', 'fm_carousel' ); ?>" />
					<input type="button" class="button" id="fm-add-video" value="<?php _e( 'Add Video', 'fm_carousel' ); ?>" />
					<input type="button" class="button" id="fm-add-youtube" value="<?php _e( 'Add YouTube', 'fm_carousel' ); ?>" />
					<input type="button" class="button" id="fm-add-youtube-playlist" value="<?php _e( 'Add YouTube Playlist', 'fm_carousel' ); ?>" />
					<input type="button" class="button" id="fm-add-vimeo" value="<?php _e( 'Add Vimeo', 'fm_carousel' ); ?>" />
					<input type="button" class="button" id="fm-add-posts" value="<?php _e( 'Add Posts', 'fm_carousel' ); ?>" />
					<label style="float:right;"><input type="button" class="button" id="fm-reverselist" value="<?php _e( 'Reverse List', 'fm_carousel' ); ?>" /></label>
					<label style="float:right;padding-top:4px;margin-right:8px;"><input type='checkbox' id='fm-newestfirst' value='' /> Add new item to the beginning</label>
				</div>
        		
        		<ul class="fm-table" id="fm-carousel-media-table">
			    </ul>
			    <div style="clear:both;"></div>
      
			</li>
			<li class="fm-tab">
				<form>
					<fieldset>
						
						<?php 
						$skins = array(
								"classic" => "Default",
								"classicwithflip" => "Default + Flip",
								"gallery" => "Modern",
								"readmore" => "Read More",
								"hoverover" => "Classic",
								"flip" => "Classic + Flip",
								"scroller" => "Auto Scroll",
								"numbering" => "Enumerated",
								"highlight" => "Cards",
								"textonly" => "Text Only",
								"navigator" => "Review",
								"simplicity" => "Minimalistic",
								"stylish" => "Elegant",
								"testimonial" => "Testimonial",
								"fashion" => "Tiles",
								"flow" => "Tickers",
								"navigator" => "Navigator",
								"testimonialcarousel" => "Testimonials",
								"list" => "Annonces",
								"showcase" => "Showcase",
								"thumbnail" => "Thumbnail",
								"vertical" => "Vertical",
								"rotator" => "Rotating",
								"tworows" => "Two Rows"
								);
						
						$skin_index = 0;
						foreach ($skins as $key => $value) {
							if ($skin_index > 0 && $skin_index % 3 == 0)
								echo '<div style="clear:both;"></div>';
							$skin_index++;
						?>
							<div class="fm-tab-skin">
							<label><input type="radio" name="fm-carousel-skin" value="<?php echo $key; ?>" selected> <?php echo $value; ?> <br /><img class="selected" src="<?php echo FM_CAROUSEL_URL; ?>images/<?php echo $key; ?>.jpg" /></label>
							</div>
						<?php
						}
						?>
						
					</fieldset>
				</form>
			</li>
			<li class="fm-tab">
			
				<div class="fm-carousel-options">
					<div class="fm-carousel-options-menu" id="fm-carousel-options-menu">
						<div class="fm-carousel-options-menu-item fm-carousel-options-menu-item-selected"><?php _e( 'Style options', 'fm_carousel' ); ?></div>
						<div class="fm-carousel-options-menu-item"><?php _e( 'Playback options', 'fm_carousel' ); ?></div>
						<div class="fm-carousel-options-menu-item"><?php _e( 'Responsive options', 'fm_carousel' ); ?></div>
						<div class="fm-carousel-options-menu-item"><?php _e( 'Content template', 'fm_carousel' ); ?></div>
						<div class="fm-carousel-options-menu-item"><?php _e( 'Style CSS', 'fm_carousel' ); ?></div>
						<div class="fm-carousel-options-menu-item"><?php _e( 'Lightbox options', 'fm_carousel' ); ?></div>
						<div class="fm-carousel-options-menu-item"><?php _e( 'Advanced options', 'fm_carousel' ); ?></div>
					</div>
					
					<div class="fm-carousel-options-tabs" id="fm-carousel-options-tabs">
					
						<div class="fm-carousel-options-tab fm-carousel-options-tab-selected">
							<p class="fm-carousel-options-tab-title"><?php _e( 'Options will be restored to the default if you switch to a new style.', 'fm_carousel' ); ?></p>
							<table class="fm-form-table-noborder">
							
								<tr>
									<th>Width / Height</th>
									<td><label><input name="fm-carousel-width" type="text" id="fm-carousel-width" value="300" class="small-text" /> / <input name="fm-carousel-height" type="text" id="fm-carousel-height" value="300" class="small-text" /></label>
									<p><label><input name='fm-carousel-fixaspectratio' type='checkbox' id='fm-carousel-fixaspectratio'  /> Use the aspect ratio for all thumbnail images</label>
									<label><input name='fm-carousel-centerimage' type='checkbox' id='fm-carousel-centerimage'  /> Center image</label></p>
									<p><label><input name='fm-carousel-sameheight' type='checkbox' id='fm-carousel-sameheight'  /> Keep original aspect ratio of the thumnails (for horizontal style only)</label></p>
									<p><label><input name='fm-carousel-fitimage' type='checkbox' id='fm-carousel-fitimage'  /> Fit images into the slider</label>
									<label><input name='fm-carousel-fitcenterimage' type='checkbox' id='fm-carousel-fitcenterimage'  /> Center fitted image</label></p>
									</td>
								</tr>
								
								<tr>
									<th>Initialization</th>
									<td><label><input name='fm-carousel-hidecontaineroninit' type='checkbox' id='fm-carousel-hidecontaineroninit'  /> Hide the slider until the initialization finishes.</label>
									<br><label><input name='fm-carousel-hidecontainerbeforeloaded' type='checkbox' id='fm-carousel-hidecontainerbeforeloaded'  /> Hide the slider until all the images are loaded.</label>
									</td>
								</tr>
								
								<tr>
									<th>Spacing between slider items (px)</th>
									<td><label><input name="fm-carousel-spacing" type="number" id="fm-carousel-spacing" value="8" min="0" class="small-text" /></label></td>
								</tr>
								
								<tr>
									<th>Row number</th>
									<td><label><input name="fm-carousel-rownumber" type="number" id="fm-carousel-rownumber" value="1" min="1" class="small-text" /></label></td>
								</tr>
								
								<tr>
									<th>Arrows</th>
									<td><label>
										<select name='fm-carousel-arrowstyle' id='fm-carousel-arrowstyle'>
										  <option value="mouseover">Show on mouseover</option>
										  <option value="always">Always show</option>
										  <option value="none">Hide</option>
										</select>
									</label></td>
								</tr>
								<tr>
									<th>Arrow image</th>
									<td>
										<div>
											<div style="float:left;margin-right:12px;">
											<label>
											<img id="fm-carousel-displayarrowimage" />
											</label>
											</div>
											<div style="float:left;">
											<label>
												<input type="radio" name="fm-carousel-arrowimagemode" value="custom">
												<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
												<input name='fm-carousel-customarrowimage' type='text' class="regular-text" id='fm-carousel-customarrowimage' value='' />
											</label>
											<br />
											<label>
												<input type="radio" name="fm-carousel-arrowimagemode" value="defined">
												<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
												<select name='fm-carousel-arrowimage' id='fm-carousel-arrowimage'>
												<?php 
													$arrowimage_list = array("arrows-28-28-0.png", 
															"arrows-32-32-0.png", "arrows-32-32-1.png", "arrows-32-32-2.png", "arrows-32-32-3.png", "arrows-32-32-4.png", 
															"arrows-36-36-0.png", "arrows-36-36-1.png",
															"arrows-36-80-0.png",
															"arrows-42-60-0.png",
															"arrows-48-48-0.png", "arrows-48-48-1.png", "arrows-48-48-2.png", "arrows-48-48-3.png", "arrows-48-48-4.png",
															"arrows-72-72-0.png");
													foreach ($arrowimage_list as $arrowimage)
														echo '<option value="' . $arrowimage . '">' . $arrowimage . '</option>';
												?>
												</select>
											</label>
											</div>
											<div style="clear:both;"></div>
										</div>
										<script language="JavaScript">
										jQuery(document).ready(function(){
											jQuery("input:radio[name=fm-carousel-arrowimagemode]").click(function(){
												if (jQuery(this).val() == 'custom')
													jQuery("#fm-carousel-displayarrowimage").attr("src", jQuery('#fm-carousel-customarrowimage').val());
												else
													jQuery("#fm-carousel-displayarrowimage").attr("src", "<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" + jQuery('#fm-carousel-arrowimage').val());
											});

											jQuery("#fm-carousel-arrowimage").change(function(){
												if (jQuery("input:radio[name=fm-carousel-arrowimagemode]:checked").val() == 'defined')
													jQuery("#fm-carousel-displayarrowimage").attr("src", "<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" + jQuery(this).val());
												var arrowsize = jQuery(this).val().split("-");
												if (arrowsize.length > 2)
												{
													if (!isNaN(arrowsize[1]))
														jQuery("#fm-carousel-arrowwidth").val(arrowsize[1]);
													if (!isNaN(arrowsize[2]))
														jQuery("#fm-carousel-arrowheight").val(arrowsize[2]);
												}
													
											});
										});
										</script>
										<label><span style="display:inline-block;min-width:100px;">Width:</span> <input name='fm-carousel-arrowwidth' type='text' size="10" id='fm-carousel-arrowwidth' value='32' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Height:</span> <input name='fm-carousel-arrowheight' type='text' size="10" id='fm-carousel-arrowheight' value='32' /></label><br />										
									</td>
								</tr>
								
								<tr>
									<th>Navigation</th>
									<td><label>
										<select name='fm-carousel-navstyle' id='fm-carousel-navstyle'>
										  <option value="bullets">Bullets</option>
										  <option value="numbering">Numbering</option>
										  <option value="none">None</option>
										</select>
									</label>
									<label><span style="display:inline-block;">Width:</span> <input name='fm-carousel-navwidth' type='number' class="small-text" id='fm-carousel-navwidth' value='32' /></label>
									<label><span style="display:inline-block;margin-left:12px;">Height:</span> <input name='fm-carousel-navheight' type='number' class="small-text" id='fm-carousel-navheight' value='32' /></label>										
									<label><span style="display:inline-block;margin-left:12px;">Spacing:</span> <input name='fm-carousel-navspacing' type='number' class="small-text" id='fm-carousel-navspacing' value='32' /></label>	
									</td>
								</tr>
								<tr>
									<th>Bullet image</th>
									<td>
										<div>
											<div style="float:left;margin-right:12px;margin-top:4px;">
											<label>
											<img id="fm-carousel-displaynavimage" />
											</label>
											</div>
											<div style="float:left;">
											<label>
												<input type="radio" name="fm-carousel-navimagemode" value="custom">
												<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
												<input name='fm-carousel-customnavimage' type='text' class="regular-text" id='fm-carousel-customnavimage' value='' />
											</label>
											<br />
											<label>
												<input type="radio" name="fm-carousel-navimagemode" value="defined">
												<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
												<select name='fm-carousel-navimage' id='fm-carousel-navimage'>
												<?php 
													$navimage_list = array("bullet-12-12-0.png", "bullet-12-12-1.png", 
															"bullet-16-16-0.png", "bullet-16-16-1.png", "bullet-16-16-2.png", "bullet-16-16-3.png", 
															"bullet-20-20-0.png", "bullet-20-20-1.png", 
															"bullet-24-24-0.png", "bullet-24-24-1.png", "bullet-24-24-2.png", "bullet-24-24-3.png", "bullet-24-24-4.png", "bullet-24-24-5.png", "bullet-24-24-6.png");
													foreach ($navimage_list as $navimage)
														echo '<option value="' . $navimage . '">' . $navimage . '</option>';
												?>
												</select>
											</label>
											</div>
											<div style="clear:both;"></div>
										</div>
										<script language="JavaScript">
										jQuery(document).ready(function(){
											jQuery("input:radio[name=fm-carousel-navimagemode]").click(function(){
												if (jQuery(this).val() == 'custom')
													jQuery("#fm-carousel-displaynavimage").attr("src", jQuery('#fm-carousel-customnavimage').val());
												else
													jQuery("#fm-carousel-displaynavimage").attr("src", "<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" + jQuery('#fm-carousel-navimage').val());
											});

											jQuery("#fm-carousel-navimage").change(function(){
												if (jQuery("input:radio[name=fm-carousel-navimagemode]:checked").val() == 'defined')
													jQuery("#fm-carousel-displaynavimage").attr("src", "<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" + jQuery(this).val());
												var navsize = jQuery(this).val().split("-");
												if (navsize.length > 2)
												{
													if (!isNaN(navsize[1]))
														jQuery("#fm-carousel-navwidth").val(navsize[1]);
													if (!isNaN(navsize[2]))
														jQuery("#fm-carousel-navheight").val(navsize[2]);
												}
													
											});
										});
										</script>									
										</td>
								</tr>
								
								<tr>
									<th>Hover overlay</th>
									<td>
										<div>
											<div>
											<label><input name='fm-carousel-showhoveroverlay' type='checkbox' id='fm-carousel-showhoveroverlay'  /> Show hover overlay image</label>
											</div>
											<div style="float:left;margin-right:12px;">
											<label>
											<img id="fm-carousel-displayhoveroverlayimage" />
											</label>
											</div>
											<div style="float:left;">
											<label>
												<input type="radio" name="fm-carousel-hoveroverlayimagemode" value="custom">
												<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
												<input name='fm-carousel-customhoveroverlayimage' type='text' class="regular-text" id='fm-carousel-customhoveroverlayimage' value='' />
											</label>
											<br />
											<label>
												<input type="radio" name="fm-carousel-hoveroverlayimagemode" value="defined">
												<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
												<select name='fm-carousel-hoveroverlayimage' id='fm-carousel-hoveroverlayimage'>
												<?php 
													$hoveroverlayimage_list = array("hoveroverlay-64-64-0.png", "hoveroverlay-64-64-1.png", "hoveroverlay-64-64-2.png", "hoveroverlay-64-64-3.png", "hoveroverlay-64-64-4.png", "hoveroverlay-64-64-5.png", "hoveroverlay-64-64-6.png", "hoveroverlay-64-64-7.png", "hoveroverlay-64-64-8.png", "hoveroverlay-64-64-9.png");
													foreach ($hoveroverlayimage_list as $hoveroverlayimage)
														echo '<option value="' . $hoveroverlayimage . '">' . $hoveroverlayimage . '</option>';
												?>
												</select>
											</label>
											</div>
											<div style="clear:both;"></div>
										</div>
										<script language="JavaScript">
										jQuery(document).ready(function(){
											jQuery("input:radio[name=fm-carousel-hoveroverlayimagemode]").click(function(){
												if (jQuery(this).val() == 'custom')
													jQuery("#fm-carousel-displayhoveroverlayimage").attr("src", jQuery('#fm-carousel-customhoveroverlayimage').val());
												else
													jQuery("#fm-carousel-displayhoveroverlayimage").attr("src", "<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" + jQuery('#fm-carousel-hoveroverlayimage').val());
											});
											jQuery("#fm-carousel-hoveroverlayimage").change(function(){
												if (jQuery("input:radio[name=fm-carousel-hoveroverlayimagemode]:checked").val() == 'defined')
													jQuery("#fm-carousel-displayhoveroverlayimage").attr("src", "<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" + jQuery(this).val());
											});
										});
										</script>
										<label><span style="display:inline-block;min-width:100px;">Width:</span> <input name='fm-carousel-arrowwidth' type='text' size="10" id='fm-carousel-arrowwidth' value='32' /></label>
										<label><span style="display:inline-block;min-width:100px;margin-left:36px;">Height:</span> <input name='fm-carousel-arrowheight' type='text' size="10" id='fm-carousel-arrowheight' value='32' /></label><br />	
										<label><input name='fm-carousel-showhoveroverlayalways' type='checkbox' id='fm-carousel-showhoveroverlayalways'  /> Show hover image for both Lightbox and weblink</label>
										<br><label><input name='fm-carousel-hidehoveroverlayontouch' type='checkbox' id='fm-carousel-hidehoveroverlayontouch'  /> Do not show hover image on touch screen</label>									
									</td>
								</tr>
								
								<tr>
									<th>Video play button</th>
									<td>
										<div>
											<div>
											<label><input name='fm-carousel-showplayvideo' type='checkbox' id='fm-carousel-showplayvideo'  /> Show play button on video item</label>
											</div>
											<div style="float:left;margin-right:12px;">
											<label>
											<img id="fm-carousel-displayplayvideoimage" />
											</label>
											</div>
											<div style="float:left;">
											<label>
												<input type="radio" name="fm-carousel-playvideoimagemode" value="custom">
												<span style="display:inline-block;min-width:240px;">Use own image (absolute URL required):</span>
												<input name='fm-carousel-customplayvideoimage' type='text' class="regular-text" id='fm-carousel-customplayvideoimage' value='' />
											</label>
											<br />
											<label>
												<input type="radio" name="fm-carousel-playvideoimagemode" value="defined">
												<span style="display:inline-block;min-width:240px;">Select from pre-defined images:</span>
												<select name='fm-carousel-playvideoimage' id='fm-carousel-playvideoimage'>
												<?php 
													$playvideoimage_list = array("playvideo-64-64-0.png", "playvideo-64-64-1.png", "playvideo-64-64-2.png", "playvideo-64-64-3.png", "playvideo-64-64-4.png", "playvideo-64-64-5.png");
													foreach ($playvideoimage_list as $playvideoimage)
														echo '<option value="' . $playvideoimage . '">' . $playvideoimage . '</option>';
												?>
												</select>
											</label>
											</div>
											<div style="clear:both;"></div>
										</div>
										<script language="JavaScript">
										jQuery(document).ready(function(){
											jQuery("input:radio[name=fm-carousel-playvideoimagemode]").click(function(){
												if (jQuery(this).val() == 'custom')
													jQuery("#fm-carousel-displayplayvideoimage").attr("src", jQuery('#fm-carousel-customplayvideoimage').val());
												else
													jQuery("#fm-carousel-displayplayvideoimage").attr("src", "<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" + jQuery('#fm-carousel-playvideoimage').val());
											});
											jQuery("#fm-carousel-playvideoimage").change(function(){
												if (jQuery("input:radio[name=fm-carousel-playvideoimagemode]:checked").val() == 'defined')
													jQuery("#fm-carousel-displayplayvideoimage").attr("src", "<?php echo FM_CAROUSEL_URL . 'engine/'; ?>" + jQuery(this).val());
											});
										});
										</script>	
										<p>Play button position:<label>
										<select name='fm-carousel-playvideoimagepos' id='fm-carousel-playvideoimagepos'>
										  <option value="center">center</option>
										  <option value="topleft">topleft</option>
										  <option value="topright">topright</option>
										  <option value="bottomleft">bottomleft</option>
										  <option value="bottomright">bottomright</option>
										</select></label></p>			
									</td>
								</tr>
								
								<tr>
									<th>Add extra tags or attributes to img elements</th>
									<td><label><input name="fm-carousel-imgextraprops" type="text" id="fm-carousel-imgextraprops" value="" class="regular-text" /></label></td>
								</tr>
								
							</table>
						</div>
						
						<div class="fm-carousel-options-tab">
							<table class="fm-form-table-noborder">
								
								<tr>
									<th>Play mode</th>
									<td><p><label><input name='fm-carousel-autoplay' type='checkbox' id='fm-carousel-autoplay'  /> Auto play</label></p>
									<p><label><input name='fm-carousel-random' type='checkbox' id='fm-carousel-random'  /> Random</label></p>
									<p><label><input name='fm-carousel-pauseonmouseover' type='checkbox' id='fm-carousel-pauseonmouseover'  /> Pause on mouse over</label></p>
									<p><label><input name='fm-carousel-circular' type='checkbox' id='fm-carousel-circular'  /> Circular</label></p>
									</td>
								</tr>
								
								<tr>
									<th>Scroll mode</th>
									<td><label>
										<select name='fm-carousel-scrollmode' id='fm-carousel-scrollmode'>
										  <option value="page">Page</option>
										  <option value="item">Item</option>
										</select>
									</label></td>
								</tr>
								
								<tr>
									<th>Interval (ms)</th>
									<td><label><input name="fm-carousel-interval" type="number" id="fm-carousel-interval" value="3000" min="0" class="small-text" /></label></td>
								</tr>
								
								<tr>
									<th>Transition duration (ms)</th>
									<td><label><input name="fm-carousel-transitionduration" type="number" id="fm-carousel-transitionduration" value="1000" min="0" class="small-text" /></label></td>
								</tr>
								
								<tr>
									<th>Continuous playing</th>
									<td><label><input name='fm-carousel-continuous' type='checkbox' id='fm-carousel-continuous'  /> Continuous playing</label>
									<br /><label>Duration of moving one item (ms): <input name="fm-carousel-continuousduration" type="number" id="fm-carousel-continuousduration" value="2500" min="0" class="small-text" /></label>
									</td>
								</tr>
								
							</table>
						</div>
							
						<div class="fm-carousel-options-tab">
							<table class="fm-form-table-noborder">

								<tr>
									<th>Visible items</th>
									<td><label><input name='fm-carousel-visibleitems' type='number' size="10" id='fm-carousel-visibleitems' value='3' /></label></td>
								</tr>
								
								<tr>
									<th>Width</th>
									<td><label><input name='fm-carousel-responsive' type='checkbox' id='fm-carousel-responsive'  /> Responsive</label>
									&nbsp;&nbsp;&nbsp;&nbsp;<label><input name='fm-carousel-fullwidth' type='checkbox' id='fm-carousel-fullwidth'  /> Full-width</label>
									</td>
								</tr>
								
								<tr>
									<th>Responsive mode</th>
									<td>
										<label>
											<input type="radio" name="fm-carousel-usescreenquery" value="fixedsize">
											Change the number of visible items according to the container size, keep item size unchanged
										</label>
										<br /><br />
										<label>
											<input type="radio" name="fm-carousel-usescreenquery" value="screensize">
											Change the number of visible items according to the screen size, adjust item size accordingly:
										</label>
										<textarea style="margin-left:16px;" name='fm-carousel-screenquery' id='fm-carousel-screenquery' value='' class='large-text' rows="10"></textarea>
									</td>
								</tr>
									
								<tr>
									<th>When the option "Keep original aspect ratio of the thumnails" is checked</th>
									<td>
									<label><input name='fm-carousel-sameheightresponsive' type='checkbox' id='fm-carousel-sameheightresponsive'  />Change the slider height on small screens:</label>
									<p>When the screen width is less than (px) <input name='fm-carousel-sameheightmediumscreen' type='number' id='fm-carousel-sameheightmediumscreen' value='769' class='small-text' />, change the slider height to (px) <input name='fm-carousel-sameheightmediumheight' type='number' class="small-text"  id='fm-carousel-sameheightmediumheight' value='200' /></p>
									<p>When the screen width is less than (px) <input name='fm-carousel-sameheightsmallscreen' type='number' id='fm-carousel-sameheightsmallscreen' value='415' class='small-text' />, change the slider height to (px) <input name='fm-carousel-sameheightsmallheight' type='number' class="small-text"  id='fm-carousel-sameheightsmallheight' value='150' /></p>
									</td>
								</tr>		
							</table>
						</div>
						
						<div class="fm-carousel-options-tab">
							<table class="fm-form-table-noborder">
								<tr>
									<th>Style template</th>
									<td><textarea name='fm-carousel-skintemplate' id='fm-carousel-skintemplate' value='' class='large-text' rows="20"></textarea></td>
								</tr>
							</table>
						</div>
						
						<div class="fm-carousel-options-tab">
							<table class="fm-form-table-noborder">
								<tr>
									<th>Style CSS</th>
									<td><textarea name='fm-carousel-skincss' id='fm-carousel-skincss' value='' class='large-text' rows="20"></textarea></td>
								</tr>
							</table>
						</div>
						
						<div class="fm-carousel-options-tab" style="padding:24px;">
						
						
						<ul class="fm-tab-buttons-horizontal" data-panelsid="fm-lightbox-panels">
							<li class="fm-tab-button-horizontal fm-tab-button-horizontal-selected"><?php _e( 'General', 'fm_carousel' ); ?></li>
							<li class="fm-tab-button-horizontal"></span><?php _e( 'Video', 'fm_carousel' ); ?></li>
							<li class="fm-tab-button-horizontal"></span><?php _e( 'Thubmails', 'fm_carousel' ); ?></li>
							<li class="fm-tab-button-horizontal"></span><?php _e( 'Text', 'fm_carousel' ); ?></li>
							<li class="fm-tab-button-horizontal"></span><?php _e( 'Social Media', 'fm_carousel' ); ?></li>
							<li class="fm-tab-button-horizontal"></span><?php _e( 'Lightbox Advanced Options', 'fm_carousel' ); ?></li>
							<div style="clear:both;"></div>
						</ul>
						
						<ul class="fm-tabs-horizontal" id="fm-lightbox-panels">
						
							<li class="fm-tab-horizontal fm-tab-horizontal-selected">
							<table class="fm-form-table-noborder">
								<tr>
									<th>General</th>
									<td><label><input name='fm-carousel-lightboxresponsive' type='checkbox' id='fm-carousel-lightboxresponsive'  /> Responsive</label>
									<br><label><input name="fm-carousel-lightboxfullscreenmode" type="checkbox" id="fm-carousel-lightboxfullscreenmode" /> Display in fullscreen mode (the close button on top right of the web browser)</label>
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">Slideshow</th>
									<td><label><input name="fm-carousel-lightboxautoslide" type="checkbox" id="fm-carousel-lightboxautoslide" /> Auto play slideshow</label>
									<label> - slideshow interval (ms): <input name="fm-carousel-lightboxslideinterval" type="number" min=0 id="fm-carousel-lightboxslideinterval" value="5000" class="small-text" /></label>
									<br><label><input name="fm-carousel-lightboximagekeepratio" type="checkbox" id="fm-carousel-lightboximagekeepratio" /> Keep image aspect ratio</label>
									<br><label><input name="fm-carousel-lightboxalwaysshownavarrows" type="checkbox" id="fm-carousel-lightboxalwaysshownavarrows" /> Always show left and right navigation arrows</label>
									<br><label><input name="fm-carousel-lightboxshowplaybutton" type="checkbox" id="fm-carousel-lightboxshowplaybutton" /> Show play slideshow button</label>
									<br><label><input name="fm-carousel-lightboxshowtimer" type="checkbox" id="fm-carousel-lightboxshowtimer" /> Show line timer for image slideshow</label>
									<br>Timer position: <select name="fm-carousel-lightboxtimerposition" id="fm-carousel-lightboxtimerposition">
										  <option value="bottom">Bottom</option>
										  <option value="top">Top</option>
										</select>
									Timer color: <input name="fm-carousel-lightboxtimercolor" type="text" id="fm-carousel-lightboxtimercolor" value="#dc572e" class="medium-text" />
									Timer height: <input name="fm-carousel-lightboxtimerheight" type="number" min=0 id="fm-carousel-lightboxtimerheight" value="2" class="small-text" />
									Timer opacity: <input name="fm-carousel-lightboxtimeropacity" type="number" min=0 max=1 step="0.1" id="fm-carousel-lightboxtimeropacity" value="1" class="small-text" />
									</td>
								</tr>
								<tr valign="top">
									<th scope="row">Overlay</th>
									<td>Color: <input name="fm-carousel-lightboxoverlaybgcolor" type="text" id="fm-carousel-lightboxoverlaybgcolor" value="#333" class="medium-text" />
									Opacity: <input name="fm-carousel-lightboxoverlayopacity" type="number" min=0 max=1 step="0.1" id="fm-carousel-lightboxoverlayopacity" value="0.9" class="small-text" />
									<label><input name="fm-carousel-lightboxcloseonoverlay" type="checkbox" id="fm-carousel-lightboxcloseonoverlay" /> Close the lightbox when clicking on the overlay background</label></td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Background color</th>
									<td><input name="fm-carousel-lightboxbgcolor" type="text" id="fm-carousel-lightboxbgcolor" value="#fff" class="medium-text" /></td>
								</tr>
		
								<tr valign="top">
									<th scope="row">Border</th>
									<td>Border radius (px): <input name="fm-carousel-lightboxborderradius" type="number" min=0 id="fm-carousel-lightboxborderradius" value="0" class="small-text" />
									Border size (px): <input name="fm-carousel-lightboxbordersize" type="number" min=0 id="fm-carousel-lightboxbordersize" value="8" class="small-text" />
									</td>
								</tr>
								<tr>
									<th>Group</th>
									<td><label><input name='fm-carousel-lightboxnogroup' type='checkbox' id='fm-carousel-lightboxnogroup'  /> Do not display lightboxes as a group</label>
									</td>
								</tr>
							</table>
							</li>
							
							<li class="fm-tab-horizontal">
							<table class="fm-form-table-noborder">
								<tr valign="top">
									<th scope="row">Default volume of MP4/WebM videos</th>
									<td><label><input name="fm-carousel-lightboxdefaultvideovolume" type="number" min=0 max=1 step="0.1" id="fm-carousel-lightboxdefaultvideovolume" value="1" class="small-text" /> (0 - 1)</label></td>
								</tr>
		
								<tr>
									<th>Video</th>
									<td><label><input name='fm-carousel-lightboxvideohidecontrols' type='checkbox' id='fm-carousel-lightboxvideohidecontrols'  /> Hide MP4/WebM video play control bar</label>
									<p style="font-style:italic;">* Video autoplay is not supported on mobile and tables. The limitation comes from iOS and Android.</p>
									</td>
								</tr>
							</table>
							</li>
							
							<li class="fm-tab-horizontal">
							<table class="fm-form-table-noborder">
								<tr>
									<th>Thumbnails</th>
									<td><label><input name='fm-carousel-lightboxshownavigation' type='checkbox' id='fm-carousel-lightboxshownavigation'  /> Show thumbnails</label>
									</td>
								</tr>
								<tr>
									<th></th>
									<td><label>Thumbnail size: <input name="fm-carousel-lightboxthumbwidth" type="number" id="fm-carousel-lightboxthumbwidth" value="96" class="small-text" /> x <input name="fm-carousel-lightboxthumbheight" type="number" id="fm-carousel-lightboxthumbheight" value="72" class="small-text" /></label> 
									<label>Thumbnail top margin: <input name="fm-carousel-lightboxthumbtopmargin" type="number" id="fm-carousel-lightboxthumbtopmargin" value="12" class="small-text" /> Thumbnail bottom margin: <input name="fm-carousel-lightboxthumbbottommargin" type="number" id="fm-carousel-lightboxthumbbottommargin" value="12" class="small-text" /></label>
									</td>
								</tr>
							</table>
							</li>
							
							<li class="fm-tab-horizontal">
							<table class="fm-form-table-noborder">
								<tr valign="top">
									<th scope="row">Text position</th>
									<td>
										<select name="fm-carousel-lightboxtitlestyle" id="fm-carousel-lightboxtitlestyle">
										  <option value="bottom">Bottom</option>
										  <option value="inside">Inside</option>
										  <option value="right">Right</option>
										  <option value="left">Left</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>Maximum text bar height when text position is bottom</th>
									<td><label><input name="fm-carousel-lightboxbarheight" type="number" id="fm-carousel-lightboxbarheight" value="64" class="small-text" /></label>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Image/video width percentage when text position is right or left</th>
									<td><input name="fm-carousel-lightboximagepercentage" type="number" id="fm-carousel-lightboximagepercentage" value="75" class="small-text" />%</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Title</th>
									<td><label><input name="fm-carousel-lightboxshowtitle" type="checkbox" id="fm-carousel-lightboxshowtitle" /> Show title</label></td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Add the following prefix to title</th>
									<td><label><input name="fm-carousel-lightboxshowtitleprefix" type="checkbox" id="fm-carousel-lightboxshowtitleprefix" /> Add prefix:</label><input name="fm-carousel-lightboxtitleprefix" type="text" id="fm-carousel-lightboxtitleprefix" value="" class="regular-text" /></td>
								</tr>
		
								<tr>
									<th>Title CSS</th>
									<td><label><textarea name="fm-carousel-lightboxtitlebottomcss" id="fm-carousel-lightboxtitlebottomcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Title CSS when text position is inside</th>
									<td><textarea name="fm-carousel-lightboxtitleinsidecss" id="fm-carousel-lightboxtitleinsidecss" rows="2" class="large-text code"></textarea></td>
								</tr>
		
								<tr valign="top">
									<th scope="row">Description</th>
									<td><label><input name="fm-carousel-lightboxshowdescription" type="checkbox" id="fm-carousel-lightboxshowdescription" /> Show description</label></td>
								</tr>
								
								<tr>
									<th>Description CSS</th>
									<td><label><textarea name="fm-carousel-lightboxdescriptionbottomcss" id="fm-carousel-lightboxdescriptionbottomcss" rows="2" class="large-text code"></textarea></label>
									</td>
								</tr>
								
								<tr valign="top">
									<th scope="row">Description CSS when text position is inside</th>
									<td><textarea name="fm-carousel-lightboxdescriptioninsidecss" id="fm-carousel-lightboxdescriptioninsidecss" rows="2" class="large-text code"></textarea></td>
								</tr>
							</table>
							</li>
							
							<li class="fm-tab-horizontal">
							<table class="fm-form-table-noborder">
							<tr valign="top">
								<th scope="row">Social Media</th>
								<td><label for="fm-carousel-lightboxshowsocial"><input name="fm-carousel-lightboxshowsocial" type="checkbox" id="fm-carousel-lightboxshowsocial" /> Enable social media</label>
								<p><label for="fm-carousel-lightboxshowfacebook"><input name="fm-carousel-lightboxshowfacebook" type="checkbox" id="fm-carousel-lightboxshowfacebook" /> Show Facebook button</label>
								<br><label for="fm-carousel-lightboxshowtwitter"><input name="fm-carousel-lightboxshowtwitter" type="checkbox" id="fm-carousel-lightboxshowtwitter" /> Show Twitter button</label>
								<br><label for="fm-carousel-lightboxshowpinterest"><input name="fm-carousel-lightboxshowpinterest" type="checkbox" id="fm-carousel-lightboxshowpinterest" /> Show Pinterest button</label></p>
								</td>
							</tr>
				        	
				        	<tr valign="top">
								<th scope="row">Position and Size</th>
								<td>
								Position CSS: <input name="fm-carousel-lightboxsocialposition" type="text" id="fm-carousel-lightboxsocialposition" value="" class="regular-text" />
								<p>Position CSS on small screen: <input name="fm-carousel-lightboxsocialpositionsmallscreen" type="text" id="fm-carousel-lightboxsocialpositionsmallscreen" value="" class="regular-text" /></p>
								<p>Button size: <input name="fm-carousel-lightboxsocialbuttonsize" type="number" id="fm-carousel-lightboxsocialbuttonsize" value="32" class="small-text" />
								Button font size: <input name="fm-carousel-lightboxsocialbuttonfontsize" type="number" id="fm-carousel-lightboxsocialbuttonfontsize" value="18" class="small-text" />
								Buttons direction:
								<select name="fm-carousel-lightboxsocialdirection" id="fm-carousel-lightboxsocialdirection">
								  <option value="horizontal" selected="selected">horizontal</option>
								  <option value="vertical">>vertical</option>
								</select>
								</p>
								<p><label for="fm-carousel-lightboxsocialrotateeffect"><input name="fm-carousel-lightboxsocialrotateeffect" type="checkbox" id="fm-carousel-lightboxsocialrotateeffect" /> Enable button rotating effect on mouse hover</label></p>	
								</td>
							</tr>
							</table>
							</li>
							
							<li class="fm-tab-horizontal">
							<table class="fm-form-table-noborder">
								<tr valign="top">
									<th scope="row">Lightbox Advanced Options</th>
									<td><textarea name="fm-carousel-lightboxadvancedoptions" id="fm-carousel-lightboxadvancedoptions" rows="4" class="large-text code"></textarea></td>
								</tr>
							</table>
							</li>
						</ul>
						
						</div>
						
						<div class="fm-carousel-options-tab">
							<table class="fm-form-table-noborder">
								<tr>
									<th></th>
									<td><p><label><input name='fm-carousel-donotinit' type='checkbox' id='fm-carousel-donotinit'  /> Do not init the slider until the page is loaded. Check this option if you would like to manually init the carousel with JavaScript API.</label></p>
									<p><label><input name='fm-carousel-addinitscript' type='checkbox' id='fm-carousel-addinitscript'  /> Add init scripts together with slider HTML code. Check this option if your WordPress site uses Ajax to load pages and posts.</label></p>
									<p><label><input name='fm-carousel-doshortcodeontext' type='checkbox' id='fm-carousel-doshortcodeontext'  /> Support shortcode in title and description</label></p>
									<p><label><input name='fm-carousel-triggerresize' type='checkbox' id='fm-carousel-triggerresize'  /> Trigger window resize event after (ms): </label><input name="fm-carousel-triggerresizedelay" type="number" min=0 id="fm-carousel-triggerresizedelay" value="0" class="small-text" /></p>
									</td>
								</tr>
								<tr>
									<th>Custom CSS</th>
									<td><textarea name='fm-carousel-custom-css' id='fm-carousel-custom-css' value='' class='large-text' rows="10"></textarea></td>
								</tr>
								<tr>
									<th>Advanced Options</th>
									<td><textarea name='fm-carousel-data-options' id='fm-carousel-data-options' value='' class='large-text' rows="10"></textarea></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
				<div style="clear:both;"></div>
				
			</li>
			<li class="fm-tab">
				<div id="fm-carousel-preview-tab">
					<div id="fm-carousel-preview-message"></div>
					<div id="fm-carousel-preview-container">
					</div>
				</div>
			</li>
			<li class="fm-tab">
				<div id="fm-carousel-publish-loading"></div>
				<div id="fm-carousel-publish-information"></div>
			</li>
		</ul>
		</div>
		
		<?php
	}
	
	function get_list_data() {
		return array();
	}
}