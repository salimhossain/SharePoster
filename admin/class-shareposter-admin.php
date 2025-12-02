<?php
/**
 * Admin-specific functionality for SharePoster.
 *
 * @package SharePoster
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for admin area.
 *
 * @link       https://github.com/salimhossain
 * @since      1.0.0
 * @package    SharePoster
 * @subpackage SharePoster/admin
 * @author     Salim Hossain
 */
class SharePoster_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook    The current admin page hook.
	 */
	public function enqueue_styles( $hook ) {
		// Only load on our plugin pages.
		$allowed_pages = array(
			'toplevel_page_shareposter',
			'settings_page_shareposter-settings',
			'tools_page_shareposter-tools',
		);

		if ( ! in_array( $hook, $allowed_pages, true ) ) {
			return;
		}

		// Enqueue WordPress color picker.
		wp_enqueue_style( 'wp-color-picker' );

		// Enqueue custom CSS.
		wp_enqueue_style(
			$this->plugin_name,
			SHAREPOSTER_PLUGIN_URL . 'assets/css/shareposter-admin.css',
			array(),
			$this->version,
			'all'
		);
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param    string $hook    The current admin page hook.
	 */
	public function enqueue_scripts( $hook ) {
		// Only load on our plugin pages.
		$allowed_pages = array(
			'toplevel_page_shareposter',
			'settings_page_shareposter-settings',
			'tools_page_shareposter-tools',
		);

		if ( ! in_array( $hook, $allowed_pages, true ) ) {
			return;
		}

		// Enqueue html2canvas.
		wp_enqueue_script(
			$this->plugin_name . '-html2canvas',
			SHAREPOSTER_PLUGIN_URL . 'assets/js/html2canvas.min.js',
			array(),
			'1.4.1',
			true
		);

		// Enqueue custom JS.
		wp_enqueue_script(
			$this->plugin_name,
			SHAREPOSTER_PLUGIN_URL . 'assets/js/shareposter-admin.js',
			array( 'jquery', 'wp-color-picker', $this->plugin_name . '-html2canvas' ),
			$this->version,
			true
		);

		// Enqueue WordPress media uploader.
		wp_enqueue_media();

		// Localize script with WordPress data.
		wp_localize_script(
			$this->plugin_name,
			'shareposter_data',
			array(
				'ajax_url'   => admin_url( 'admin-ajax.php' ),
				'nonce'      => wp_create_nonce( 'shareposter_nonce' ),
				'plugin_url' => SHAREPOSTER_PLUGIN_URL,
			)
		);

		// Load TinyMCE plugins (colorpicker and charmap for special characters).
		add_filter( 'mce_external_plugins', array( $this, 'add_tinymce_plugins' ) );
	}

	/**
	 * Load TinyMCE plugins.
	 *
	 * @since    1.0.0
	 * @param    array $plugins    External plugins array.
	 * @return   array                Modified plugins array.
	 */
	public function add_tinymce_plugins( $plugins ) {
		// Load colorpicker plugin for color button support.
		if ( ! isset( $plugins['colorpicker'] ) ) {
			$plugins['colorpicker'] = includes_url( 'js/tinymce/plugins/colorpicker/plugin.min.js' );
		}
		// Load charmap plugin for special character support.
		if ( ! isset( $plugins['charmap'] ) ) {
			$plugins['charmap'] = includes_url( 'js/tinymce/plugins/charmap/plugin.min.js' );
		}
		return $plugins;
	}

	/**
	 * Add admin menu pages.
	 *
	 * @since    1.0.0
	 */
	public function add_admin_menu() {
		// Add as main menu.
		add_menu_page(
			__( 'SharePoster', 'shareposter' ),
			__( 'SharePoster', 'shareposter' ),
			'edit_posts',
			'shareposter',
			array( $this, 'display_admin_page' ),
			'dashicons-camera-alt',
			30
		);
	}

	/**
	 * Add "Settings" link to plugin actions on the Plugins page.
	 *
	 * @since    1.0.0
	 * @param    array $links    Existing plugin action links.
	 * @return   array              Modified plugin action links.
	 */
	public function add_plugin_action_links( $links ) {
		$settings_link = '<a href="' . esc_url( admin_url( 'admin.php?page=shareposter' ) ) . '">' . esc_html__( 'Settings', 'shareposter' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	/**
	 * Add meta box to post editor.
	 *
	 * @since    1.0.0
	 */
	public function add_meta_box() {
		add_meta_box(
			'shareposter_meta_box',
			__( 'SharePoster', 'shareposter' ),
			array( $this, 'render_meta_box' ),
			'post',
			'side',
			'high'
		);
	}

	/**
	 * Render meta box content.
	 *
	 * @since    1.0.0
	 * @param    WP_Post $post    The post object (required by WordPress meta box callback).
	 */
	public function render_meta_box( $post ) { // phpcs:ignore Generic.CodeAnalysis.UnusedFunctionParameter.Found
		$post_id = get_the_ID();
		$url     = add_query_arg(
			array(
				'page'     => 'shareposter',
				'p'        => $post_id,
				'_wpnonce' => wp_create_nonce( 'shareposter_action' ),
			),
			admin_url( 'admin.php' )
		);
		?>
		<div class="shareposter-meta-box-wrapper">
			<div>
				<div class="post-link">
					<a id="shareposter-title" href="<?php echo esc_url( $url ); ?>" target="_blank" class="swp-d-flex swp-align-items-center goto-post" style="display: flex;font-size: 16px;text-decoration: none;">
						<svg xmlns="http://www.w3.org/2000/svg" height="24" fill="none" viewBox="0 0 24 24">
							<path stroke="#2271b1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 5H8.2c-1.12 0-1.68 0-2.108.218a1.999 1.999 0 0 0-.874.874C5 6.52 5 7.08 5 8.2v7.6c0 1.12 0 1.68.218 2.108a2 2 0 0 0 .874.874c.427.218.987.218 2.105.218h7.606c1.118 0 1.677 0 2.104-.218.377-.192.683-.498.875-.874.218-.428.218-.987.218-2.105V14m1-5V4m0 0h-5m5 0-7 7"/>
						</svg>
						<span><?php esc_html_e( 'Get SharePoster Image', 'shareposter' ); ?></span>
					</a>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Display admin page content.
	 *
	 * @since    1.0.0
	 */
	public function display_admin_page() {
		// Check user capabilities.
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'shareposter' ) );
		}

		// Get post ID from URL parameter.
		if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'shareposter_action' ) ) {
			$post_id = isset( $_GET['p'] ) ? absint( $_GET['p'] ) : 0;
		} else {
			$post_id = 0; // Or handle error.
		}
		$post_title         = '';
		$featured_image_url = '';
		$post_date          = '';
		$post_category      = '';
		$post_categories    = '';

		// If post ID is provided, get post data.
		if ( $post_id > 0 ) {
			$post = get_post( $post_id );
			if ( $post ) {
				$post_title        = get_the_title( $post_id );
				$featured_image_id = get_post_thumbnail_id( $post_id );

				if ( $featured_image_id ) {
					$featured_image_url = wp_get_attachment_image_url( $featured_image_id, 'full' );
				}

				$post_date = get_the_date( 'F j, Y', $post_id );

				// Get the categories.
				$categories    = get_the_category( $post_id );
				$post_category = ! empty( $categories ) ? $categories[0]->name : '';

				$category_names = array();
				if ( ! empty( $categories ) ) {
					foreach ( $categories as $cat ) {
						$category_names[] = $cat->name;
					}
				}

				$post_categories = implode( ', ', $category_names );
			}
		}

		// Get saved settings from database with defaults.
		$saved_settings = get_option( 'shareposter_settings', array() );
		$saved_settings = wp_parse_args( $saved_settings, $this->get_default_settings() );

		// Include admin page template.
		require_once SHAREPOSTER_PLUGIN_DIR . 'admin/partials/shareposter-admin-display.php';
	}

	/**
	 * Get default settings.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @return   array    Default settings.
	 */
	private function get_default_settings() {
		return array(
			'bg_image_url'   => SHAREPOSTER_PLUGIN_URL . 'assets/images/background.png',
			'website_url'    => get_bloginfo( 'url' ),
			'image_position' => 'center center',
			'text_color'     => '#000000',
			'title_position' => 'top',
			'details'        => __( '•••• Details in Comments ••••', 'shareposter' ),
			'post_category'  => 'Politics',
			'post_date'      => 'January 10, 2026',
		);
	}

	/**
	 * Save settings via AJAX.
	 *
	 * @since    1.0.0
	 */
	public function save_settings() {
		// Verify nonce.
		check_ajax_referer( 'shareposter_nonce', 'nonce' );

		// Check user capabilities.
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( esc_html__( 'Insufficient permissions', 'shareposter' ) );
		}

		// Sanitize and prepare settings.
		$settings = array(
			'bg_image_url'   => isset( $_POST['bg_image_url'] ) ? esc_url_raw( wp_unslash( $_POST['bg_image_url'] ) ) : '',
			'website_url'    => isset( $_POST['website_url'] ) ? sanitize_text_field( wp_unslash( $_POST['website_url'] ) ) : '',
			'image_position' => isset( $_POST['image_position'] ) ? sanitize_text_field( wp_unslash( $_POST['image_position'] ) ) : 'center center',
			'text_color'     => isset( $_POST['text_color'] ) ? sanitize_hex_color( wp_unslash( $_POST['text_color'] ) ) : '#000000',
			'title_position' => isset( $_POST['title_position'] ) ? sanitize_text_field( wp_unslash( $_POST['title_position'] ) ) : 'top',
			'details'        => isset( $_POST['details'] ) ? sanitize_text_field( wp_unslash( $_POST['details'] ) ) : '',
			'post_category'  => isset( $_POST['post_category'] ) ? sanitize_text_field( wp_unslash( $_POST['post_category'] ) ) : 'Politics',
			'post_date'      => isset( $_POST['post_date'] ) ? sanitize_text_field( wp_unslash( $_POST['post_date'] ) ) : 'January 10, 2026',
		);

		// Update option.
		update_option( 'shareposter_settings', $settings );

		wp_send_json_success( esc_html__( 'Settings saved successfully', 'shareposter' ) );
	}

	/**
	 * Reset settings via AJAX.
	 *
	 * @since    1.0.0
	 */
	public function reset_settings() {
		// Verify nonce.
		check_ajax_referer( 'shareposter_nonce', 'nonce' );

		// Check user capabilities.
		if ( ! current_user_can( 'edit_posts' ) ) {
			wp_send_json_error( esc_html__( 'Insufficient permissions', 'shareposter' ) );
		}

		// Delete the settings from database.
		delete_option( 'shareposter_settings' );

		// Return default values.
		$defaults = $this->get_default_settings();

		wp_send_json_success( $defaults );
	}
}