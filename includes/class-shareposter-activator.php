<?php
/**
 * Fired during plugin activation.
 *
 * @package SharePoster
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link       https://github.com/salimhossain
 * @since      1.0.0
 * @package    SharePoster
 * @subpackage SharePoster/includes
 * @author     Salim Hossain
 */
class SharePoster_Activator {

	/**
	 * Plugin activation.
	 *
	 * Set default options on activation.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Set default options on activation.
		if ( ! get_option( 'shareposter_settings' ) ) {
			$defaults = array(
				'bg_image_url'   => SHAREPOSTER_PLUGIN_URL . 'assets/images/background.png',
				'website_url'    => get_bloginfo( 'url' ),
				'image_position' => 'center center',
				'text_color'     => '#000000',
				'title_position' => 'top',
				'details'        => __( '•••• Details in Comments ••••', 'shareposter' ),
				'post_category'  => 'Politics',
				'post_date'      => 'January 10, 2026',
			);
			add_option( 'shareposter_settings', $defaults );
		}

		// Flush rewrite rules.
		flush_rewrite_rules();
	}
}
