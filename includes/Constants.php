<?php
/**
 * Constants used throughout the plugin.
 *
 * @package Nahidul_Api_Fetcher
 */

namespace Nahidul\ApiFetcher;

defined( 'ABSPATH' ) || exit;

/**
 * Class Constants
 *
 * Provides constants and utility methods for the Nahidul API Fetcher plugin.
 */
class Constants {

	const NAHIDUL_API_FETCHER_VERSION            = '1.0.0';
	const NAHIDUL_API_FETCHER_SLUG               = 'nahidul-api-fetcher';
	const NAHIDUL_API_FETCHER_REMOTE_URL         = 'https://miusage.com/v1/challenge/1/';
	const NAHIDUL_API_FETCHER_TRANSIENT_KEY      = 'nahidul_api_fetcher_data';
	const NAHIDUL_API_FETCHER_TRANSIENT_OVERRIDE = 'nahidul_api_fetcher_force_refresh';
	const NAHIDUL_API_FETCHER_TRANSIENT_EXPIRY   = HOUR_IN_SECONDS;

	const NAHIDUL_API_FETCHER_MENU_SLUG          = 'nahidul-api-fetcher';
	const NAHIDUL_API_FETCHER_CAPABILITY         = 'manage_options';

	// Nonce and option key
	const NAHIDUL_API_FETCHER_NONCE_ACTION    = 'nahidul_api_fetcher_nonce';
	const NAHIDUL_API_FETCHER_OPTION_KEY      = 'nahidul_api_fetcher_options';

	// Asset handles
	const NAHIDUL_API_FETCHER_ASSET_HANDLE_ADMIN = 'nahidul-api-fetcher-admin';
	const NAHIDUL_API_FETCHER_ASSET_HANDLE_BLOCK = 'nahidul-api-fetcher-block';

	// File type or suffix (e.g., .min.css)
	const NAHIDUL_API_FETCHER_CSS_EXT         = '.css';

	// Asset folders
	const NAHIDUL_API_FETCHER_ASSETS_FOLDER   = 'build';

	/**
	 * Get plugin directory path.
	 *
	 * @return string
	 */
	public static function get_plugin_dir() {
		return plugin_dir_path( self::get_plugin_file() );
	}

	/**
	 * Get plugin URL.
	 *
	 * @return string
	 */
	public static function get_plugin_url() {
		return plugin_dir_url( self::get_plugin_file() );
	}

	/**
	 * Get plugin main file path.
	 *
	 * @return string
	 */
	public static function get_plugin_file() {
		return dirname( __DIR__ ) . '/nahidul-api-fetcher.php';
	}

	/**
	 * Get plugin basename.
	 *
	 * @return string
	 */
	public static function get_plugin_basename() {
		return plugin_basename( self::get_plugin_file() );
	}

	/**
	 * Get assets URL.
	 *
	 * @return string
	 */
	public static function get_assets_url() {
		return self::get_plugin_url() . self::NAHIDUL_API_FETCHER_ASSETS_FOLDER . '/';
	}

	/**
	 * Get JavaScript assets URL.
	 *
	 * @return string
	 */
	public static function get_js_url() {
		return self::get_assets_url() . 'js/';
	}

	/**
	 * Get CSS assets URL.
	 *
	 * @return string
	 */
	public static function get_css_url() {
		return self::get_assets_url() . 'css/';
	}

	/**
	 * Get lib URL.
	 *
	 * @return string
	 */
	public static function get_lib_url() {
		return self::get_plugin_url() . 'src/lib/';
	}
}
