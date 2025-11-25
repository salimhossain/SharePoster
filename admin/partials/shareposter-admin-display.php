<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/salimhossain
 * @since      1.0.0
 *
 * @package    SharePoster_WP
 * @subpackage SharePoster_WP/admin/partials
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="wrap">
	<h1 style="display:none;"><?php esc_html_e( 'SharePoster', 'shareposter' ); ?></h1>
	<div class="shareposter-admin-wrap">
		<div class="swp-container-fluid">
			<div class="swp-header swp-justify-center">
				<div class="swp-col-100">
					<h3 class="shareposter-title swp-alert swp-text-white swp-px-4 swp-py-3 swp-mt-3 swp-text-left" role="alert">
						<strong><?php esc_html_e( 'SharePoster', 'shareposter' ); ?></strong>
					</h3>
				</div>
			</div>

			<div class="swp-content-wrap swp-row swp-justify-center">
				<div class="swp-content swp-col-lg-8 swp-order-2">
					
					<?php if ( $post_id > 0 ) : ?>
					<div class="swp-preview-link swp-d-flex swp-alert swp-alert-info swp-mb-3">
						<div class="post-info">
							<strong><?php esc_html_e( 'Editing Post:', 'shareposter' ); ?></strong> <?php echo esc_html( get_the_title( $post_id ) ); ?>
							<br /><small><?php esc_html_e( 'Post ID:', 'shareposter' ); 
							echo absint( $post_id );
							?></small>
						</div>
						<div class="post-link">
							<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" target="_blank" class="swp-d-flex swp-align-items-center goto-post">
								<svg xmlns="http://www.w3.org/2000/svg" height="24" fill="none" viewBox="0 0 24 24">
									<path stroke="#2271b1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 5H8.2c-1.12 0-1.68 0-2.108.218a1.999 1.999 0 0 0-.874.874C5 6.52 5 7.08 5 8.2v7.6c0 1.12 0 1.68.218 2.108a2 2 0 0 0 .874.874c.427.218.987.218 2.105.218h7.606c1.118 0 1.677 0 2.104-.218.377-.192.683-.498.875-.874.218-.428.218-.987.218-2.105V14m1-5V4m0 0h-5m5 0-7 7"/>
								</svg> 
								<span><?php esc_html_e( 'Post Link', 'shareposter' ); ?></span>
							</a>
						</div>
					</div>
					<?php endif; ?>

					<div class="swp-overflow-auto swp-mt-3">
						<div id="shareshap-card" class="swp-m-auto swp-poster-card">
							<div class="swp-poster-bg">
								<img class="swp-w-100" id="bg-preview-img" src="<?php echo esc_url( $saved_settings['bg_image_url'] ); ?>" alt="<?php esc_attr_e( 'Background', 'shareposter' ); ?>">
							</div>
							<div class="swp-poster-content swp-p-0">
								<div class="swp-poster-header swp-px-3 swp-py-2">
									<div class="swp-row">
										<div class="swp-col-50 swp-d-flex swp-align-items-center">
											<div class="swp-meta">
												<span class="swp-fw-bold"><?php 
													echo $post_category ? esc_html( $post_category ) : esc_html__( 'Politics', 'shareposter' );
												?></span> | <?php 
													echo $post_date ? esc_html( $post_date ) : esc_html__( 'January 10, 2026', 'shareposter' );
												?>
											</div>
										</div>
										<div class="swp-poster-logo swp-col-50 swp-float-end">
											<?php
											if ( get_custom_logo() ) {
												echo esc_html(get_custom_logo());
											} else {
												echo '<img class="swp-float-end" src="' . esc_url( SHAREPOSTER_PLUGIN_URL . 'assets/images/logo.svg' ) . '" alt="' . esc_attr__( 'Logo', 'shareposter' ) . '">';
											}
											?>
										</div>
									</div>
								</div>
								<div class="swp-poster-body swp-d-flex swp-flex-column">
									<h1 id="swp-heading" 
										class="swp-order-<?php echo $saved_settings['title_position'] === 'bottom' ? '2' : '0'; ?>"
										style="font-size: 28px; line-height: 36px; color: <?php echo esc_attr( $saved_settings['text_color'] ); ?>;">
										<?php echo $post_title ? wp_kses_post( $post_title ) : esc_html__( 'Northern Lights set to dazzle UK once again tonight', 'shareposter' ); ?>
									</h1>
									<div class="swp-pc-photo swp-text-center swp-order-<?php echo $saved_settings['title_position'] === 'bottom' ? '0' : '2'; ?>">
										<img id="swp-pc-photo" 
											 src="<?php echo $featured_image_url ? esc_url( $featured_image_url ) : esc_url( SHAREPOSTER_PLUGIN_URL . 'assets/images/default-featured-image.webp' ); ?>" 
											 alt="<?php esc_attr_e( 'Featured Image', 'shareposter' ); ?>"
											 style="object-position: <?php echo esc_attr( $saved_settings['image_position'] ); ?>;">
									</div>
								</div>
								
								<div class="swp-poster-footer swp-text-center">
									<div class="swp-learn-more"><?php echo esc_html( $saved_settings['details'] ); ?></div>
									<span class="swp-web-address"><?php echo esc_html( $saved_settings['website_url'] ); ?></span>
								</div>
							</div>
						</div>
					</div>
					
				</div>

				<div class="swp-controls-wrap swp-col-lg-4 swp-order-1">
					<div class="swp-controls-inner swp-controls swp-p-4 swp-px-4 swp-py-3">
						<div class="swp-controls-inner-item swp-mb-3 uploads-dl">
							<label for="bg_image_url" class="swp-form-label swp-text-white"><?php esc_html_e( 'Background Image', 'shareposter' ); ?></label>
							<input type="button" id="upload_bg_image" class="button button-primary swp-w-100" value="<?php esc_attr_e( 'Upload Background Image', 'shareposter' ); ?>">
							<input type="hidden" id="bg_image_url" value="<?php echo esc_url( $saved_settings['bg_image_url'] ); ?>">
						</div>
						
						<div class="swp-controls-inner-item swp-mb-3">
							<label for="text_color" class="swp-form-label swp-text-white"><?php esc_html_e( 'All Text Color', 'shareposter' ); ?></label>
							<input type="text" name="text_color" id="text_color" value="<?php echo esc_attr( $saved_settings['text_color'] ); ?>" class="swp-text-color" data-default-color="#000000" />
						</div>

						<div class="swp-controls-inner-item swp-flex-column swp-mb-3">
							<label for="heading_text" class="swp-form-label swp-text-white"><?php esc_html_e( 'Heading Text', 'shareposter' ); ?></label>
							<?php
							$shareposter_default_content = $post_title ? $post_title : __( 'Northern Lights set to dazzle UK once again tonight', 'shareposter' );
							
							wp_editor(
								$shareposter_default_content,
								'heading_text',
								array(
									'textarea_name' => 'heading_text',
									'textarea_rows' => 4,
									'media_buttons' => false,
									'teeny'         => false,
									'tinymce'       => array(
										'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
										'toolbar2' => 'forecolor,backcolor',
										'toolbar3' => '',
									),
									'quicktags'     => false,
								)
							);
							?>
						</div>
						
						<div class="swp-controls-inner-item swp-mb-3">
							<label for="swpAdjustFontSize" class="swp-form-label swp-text-white"><?php esc_html_e( 'Heading Font Size:', 'shareposter' ); ?> <span id="font_size_value">28</span>px</label>
							<input type="range" class="swp-form-range" id="swpAdjustFontSize" min="10" max="50" value="28">
						</div>
						
						<div class="swp-controls-inner-item swp-mb-3">
							<label for="swpAdjustLineHeight" class="swp-form-label swp-text-white"><?php esc_html_e( 'Heading Line Height:', 'shareposter' ); ?> <span id="line_height_value">36</span>px</label>
							<input type="range" class="swp-form-range" id="swpAdjustLineHeight" min="10" max="70" value="36">
						</div>
						
						<div class="swp-controls-inner-item custom-select swp-mb-3">
							<label for="swp-title-position" class="swp-form-label swp-text-white"><?php esc_html_e( 'Heading Position', 'shareposter' ); ?></label>
							<select id="swp-title-position" class="swp-form-select swp-w-100">
								<option value="top" <?php selected( $saved_settings['title_position'], 'top' ); ?>><?php esc_html_e( 'Top', 'shareposter' ); ?></option>
								<option value="bottom" <?php selected( $saved_settings['title_position'], 'bottom' ); ?>><?php esc_html_e( 'Bottom', 'shareposter' ); ?></option>
							</select>
						</div>
												
						<div class="swp-controls-inner-item swp-mb-3 uploads-dl">
							<label for="upload_featured_image" class="swp-form-label swp-text-white"><?php esc_html_e( 'Featured Image', 'shareposter' ); ?></label>
							<input type="button" id="upload_featured_image" class="button button-primary swp-w-100" value="<?php esc_attr_e( 'Upload Featured Image', 'shareposter' ); ?>">
							<input type="hidden" id="featured_image_url" value="<?php echo $featured_image_url ? esc_url( $featured_image_url ) : ''; ?>">
						</div>
						
						<div class="swp-controls-inner-item custom-select swp-mb-3">
							<label for="swp-picture-position" class="swp-form-label swp-text-white"><?php esc_html_e( 'Featured Image Position', 'shareposter' ); ?></label>
							<select id="swp-picture-position" class="swp-form-select swp-w-100">
								<option value="center center" <?php selected( $saved_settings['image_position'], 'center center' ); ?>><?php esc_html_e( 'Center Center', 'shareposter' ); ?></option>
								<option value="top center" <?php selected( $saved_settings['image_position'], 'top center' ); ?>><?php esc_html_e( 'Top Center', 'shareposter' ); ?></option>
								<option value="bottom center" <?php selected( $saved_settings['image_position'], 'bottom center' ); ?>><?php esc_html_e( 'Bottom Center', 'shareposter' ); ?></option>
								<option value="top left" <?php selected( $saved_settings['image_position'], 'top left' ); ?>><?php esc_html_e( 'Top Left', 'shareposter' ); ?></option>
								<option value="top right" <?php selected( $saved_settings['image_position'], 'top right' ); ?>><?php esc_html_e( 'Top Right', 'shareposter' ); ?></option>
								<option value="bottom left" <?php selected( $saved_settings['image_position'], 'bottom left' ); ?>><?php esc_html_e( 'Bottom Left', 'shareposter' ); ?></option>
								<option value="bottom right" <?php selected( $saved_settings['image_position'], 'bottom right' ); ?>><?php esc_html_e( 'Bottom Right', 'shareposter' ); ?></option>
								<option value="left center" <?php selected( $saved_settings['image_position'], 'left center' ); ?>><?php esc_html_e( 'Left Center', 'shareposter' ); ?></option>
								<option value="right center" <?php selected( $saved_settings['image_position'], 'right center' ); ?>><?php esc_html_e( 'Right Center', 'shareposter' ); ?></option>
							</select>
						</div>
						
						<div class="swp-controls-inner-item swp-mb-3">
							<label for="swp-adjust-image" class="swp-form-label swp-text-white"><?php esc_html_e( 'Zoom Image:', 'shareposter' ); ?> <span id="zoom_value">50</span>%</label>
							<input type="range" class="swp-form-range" id="swp-adjust-image" min="10" max="500" value="50">
						</div>
						
						<div class="swp-controls-inner-item swp-mb-3">
							<label for="details" class="swp-form-label swp-text-white"><?php esc_html_e( 'Details', 'shareposter' ); ?></label>
							<input type="text" id="details" class="swp-form-control" value="<?php echo esc_attr( $saved_settings['details'] ); ?>">
						</div>
						
						<div class="swp-controls-inner-item swp-mb-3">
							<label for="website_url" class="swp-form-label swp-text-white"><?php esc_html_e( 'Website URL', 'shareposter' ); ?></label>
							<input type="text" id="website_url" class="swp-form-control" value="<?php echo esc_attr( $saved_settings['website_url'] ); ?>">
						</div>
						
						<div class="swp-controls-inner-item swp-row swp-mb-3 top-bottom-0">  
							<div class="swp-col-50">
								<button type="button" id="save_all_settings" class="button button-primary swp-w-100">
									<span class="swp-icon-save"></span><?php esc_html_e( 'Save Settings', 'shareposter' ); ?>
								</button>
							</div>
							<div class="swp-col-50">
								<button type="button" id="reset_settings" class="button button-secondary swp-w-100">
									<span class="swp-icon-reset"></span><?php esc_html_e( 'Reset', 'shareposter' ); ?>
								</button>
							</div>
						</div>
						
						<div class="swp-controls-inner-item swp-row">
							<div class="swp-col">
								<button onclick="captureAndDownload()" class="swp-w-100 swp-btn swp-btn-success swp-btn-lg" id="dw_bt">
									<span class="swp-icon-download"></span><?php esc_html_e( 'Download Poster', 'shareposter' ); ?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>