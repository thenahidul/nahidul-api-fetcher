<?php
/**
 * Nahidul API Fetcher main plugin file.
 *
 * @package Nahidul_Api_Fetcher
 * @wordpress-plugin
 *
 * Plugin Name:       Nahidul API Fetcher
 * Plugin URI:        https://github.com/thenahidul/nahidul-api-fetcher
 * Description:       Fetches data from a remote API and displays it via AJAX, a Gutenberg block, an admin page, and WP-CLI.
 * Version:           1.0.0
 * Requires at least: 6.0
 * Requires PHP:      7.4
 * Author:            TheNahidul
 * Author URI:        https://www.linkedin.com/in/thenahidul/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       nahidul-api-fetcher
 * Domain Path:       /languages
 */

use Nahidul\ApiFetcher\Admin\Admin;
use Nahidul\ApiFetcher\Admin\Ajax;
use Nahidul\ApiFetcher\Admin\Block;
use Nahidul\ApiFetcher\Admin\Menu;
use Nahidul\ApiFetcher\Rest\Controller;
use Nahidul\ApiFetcher\CLI\Commands;
use Nahidul\ApiFetcher\Traits\Singleton;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Composer autoloader
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
} else {
	add_action( 'admin_notices', function () {
		?>
		<div class="error">
			<p>
				<?php
				printf(
					// translators: %s: Composer install command wrapped in <code> tag.
					esc_html__( 'Nahidul API Fetcher: Please run %s to generate the autoloader.', 'nahidul-api-fetcher' ),
					'<code>composer install</code>'
				);
				?>
			</p>
		</div>
		<?php
	} );
	return;
}

// Define constants first, right after the plugin header
if ( ! defined( 'NAHIDUL_API_FETCHER_VERSION' ) ) {
	define( 'NAHIDUL_API_FETCHER_VERSION', '1.0.0' );
}

if ( ! defined( 'NAHIDUL_API_FETCHER_PLUGIN_FILE' ) ) {
	define( 'NAHIDUL_API_FETCHER_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'NAHIDUL_API_FETCHER_PLUGIN_DIR' ) ) {
	define( 'NAHIDUL_API_FETCHER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'NAHIDUL_API_FETCHER_PLUGIN_URL' ) ) {
	define( 'NAHIDUL_API_FETCHER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'NAHIDUL_API_FETCHER_BUILD_URL' ) ) {
	define( 'NAHIDUL_API_FETCHER_BUILD_URL', NAHIDUL_API_FETCHER_PLUGIN_URL . 'build/' );
}

if ( ! defined( 'NAHIDUL_API_FETCHER_PLUGIN_BASENAME' ) ) {
	define( 'NAHIDUL_API_FETCHER_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'NAHIDUL_API_FETCHER_MENU_SLUG' ) ) {
	define( 'NAHIDUL_API_FETCHER_MENU_SLUG', 'nahidul-api-fetcher' );
}

// Other constants...
if ( ! defined( 'NAHIDUL_API_FETCHER_REMOTE_URL' ) ) {
	define( 'NAHIDUL_API_FETCHER_REMOTE_URL', 'https://miusage.com/v1/challenge/1/' );
}

if ( ! defined( 'NAHIDUL_API_FETCHER_TRANSIENT_KEY' ) ) {
	define( 'NAHIDUL_API_FETCHER_TRANSIENT_KEY', 'nahidul_api_fetcher_data' );
}


/**
 * Main plugin class.
 */
final class NahidulApiFetcherMain {
	use Singleton;

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->init();
	}

	/**
	 * Initialize the plugin.
	 */
	private function init() {
		// Load text domain for translations.
		load_plugin_textdomain( 'nahidul-api-fetcher', false, dirname( NAHIDUL_API_FETCHER_PLUGIN_BASENAME ) . '/languages' );

		// Admin Menu page
		if ( is_admin() ) {
			new Admin();
			new Menu();
		}

		// Custom blocks for Gutenberg
		new Block();

		// REST API Controller
		new Controller();

		// Ajax Handler
		new Ajax();

		// WP-CLI commands
		if ( defined( 'WP_CLI' ) && WP_CLI && class_exists( 'WP_CLI' ) ) {
			new Commands();
		}
	}

	/**
	 * Handle plugin activation logic.
	 */
	public static function activate() {
		// Do something on plugin activation.
	}

	/**
	 * Handle plugin activation logic.
	 */
	public static function deactivate() {
		// Do something on plugin activation.
	}

	/**
	 * Prevent cloning of the instance.
	 */
	private function __clone() {}

	/**
	 * Prevent unserializing of the instance.
	 */
	public function __wakeup() {}
}

add_action( 'plugins_loaded', array( 'NahidulApiFetcherMain', 'get_instance' ) );


register_activation_hook( __FILE__, array( 'NahidulApiFetcherMain', 'activate' ) );

register_deactivation_hook( __FILE__, array( 'NahidulApiFetcherMain', 'deactivate' ) );
