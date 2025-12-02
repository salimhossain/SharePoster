<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @link       https://github.com/salimhossain
 * @since      1.0.0
 *
 * @package    SharePoster
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Delete plugin settings from database.
delete_option( 'shareposter_settings' );

// For site options in Multisite.
delete_site_option( 'shareposter_settings' );
