<div class="settings-lite-cta">
	<div class="metabox-holder">
		<div class="postbox">
			<div class="inside">

				<a href="#" class="dismiss alignright" title="<?php esc_attr_e( 'Dismiss this message', 'formidable' ); ?>"><i class="dashicons dashicons-dismiss" aria-label="Dismiss" aria-hidden="true"></i></a>
				<h2><?php esc_html_e( 'Get Formidable Forms Pro and Unlock all the Powerful Features', 'formidable' ); ?></h2>
				<div class="cta-inside">
					<p><?php esc_html_e( 'Thanks for being a loyal Formidable Forms user. Upgrade to Formidable Forms Pro to unlock all the awesome features and learn how others are defying the limits by taking on big projects without big resources.', 'formidable' ); ?></p>
					<p>
						<?php esc_html_e( 'We know that you will truly love Formidable Forms.', 'formidable' ); ?>
					</p>
					<br/>
					<h3><?php esc_html_e( 'Pro Features', 'formidable' ); ?></h3>
					<ul class="frm_two_col">
						<?php foreach ( $features as $feature ) { ?>
							<li>
								<i class="dashicons dashicons-yes" aria-hidden="true"></i> <?php echo esc_html( $feature ); ?>
							</li>
						<?php } ?>
					</ul>
					<div class="clear"></div>

					<p>
						<a href="<?php echo esc_url( FrmAppHelper::admin_upgrade_link( 'settings-upgrade' ) ); ?>" target="_blank" rel="noopener noreferrer">
							<?php esc_html_e( 'Get Formidable Forms Pro Today and Unlock all the Powerful Features »', 'formidable' ); ?>
						</a>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
