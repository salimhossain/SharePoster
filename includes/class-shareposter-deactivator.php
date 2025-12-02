<?php
/**
 * Fired during plugin deactivation.
 *
 * @package SharePoster
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @link       https://github.com/salimhossain
 * @since      1.0.0
 * @package    SharePoster
 * @subpackage SharePoster/includes
 * @author     Salim Hossain
 */
class SharePoster_Deactivator {

	/**
	 * Plugin deactivation.
	 *
	 * Clean up on deactivation.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Flush rewrite rules.
		flush_rewrite_rules();
	}
}
