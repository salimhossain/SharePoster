<?php
/**
 * Plugin Name: SharePoster Generator
 * Plugin URI: https://github.com/salimhossain/SharePoster
 * Description: Instantly create 1200×1200 social media–ready posters from your WordPress posts — perfect for Facebook, Instagram, X (Twitter), and LinkedIn.
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Author: Salim Hossain
 * Author URI: https://github.com/salimhossain
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: shareposter
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 */
define( 'SHAREPOSTER_VERSION', '1.0.0' );

/**
 * Define plugin constants.
 */
define( 'SHAREPOSTER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SHAREPOSTER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'SHAREPOSTER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 */
function shareposter_activate() {
    require_once SHAREPOSTER_PLUGIN_DIR . 'includes/class-shareposter-activator.php';
    SharePoster_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function shareposter_deactivate() {
    require_once SHAREPOSTER_PLUGIN_DIR . 'includes/class-shareposter-deactivator.php';
    SharePoster_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'shareposter_activate' );
register_deactivation_hook( __FILE__, 'shareposter_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require SHAREPOSTER_PLUGIN_DIR . 'includes/class-shareposter.php';

/**
 * Begins execution of the plugin.
 */
function shareposter_run() {
    $plugin = new SharePoster();
    $plugin->run();
}
shareposter_run();