<?php
/**
 * Admin functionality for Nahidul API Fetcher.
 *
 * @package Nahidul_Api_Fetcher
 */

namespace Nahidul\ApiFetcher\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Handles admin functionality for the plugin.
 *
 * @package Nahidul_Api_Fetcher
 */
class Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Enqueue admin scripts and styles.
	 */
	/**
	 * Enqueue admin scripts and styles.
	 */
	public function enqueue_assets( $hook ) {
		if ( $hook !== 'toplevel_page_' . NAHIDUL_API_FETCHER_MENU_SLUG ) {
			return;
		}

		$asset_file = NAHIDUL_API_FETCHER_PLUGIN_DIR . 'build/admin/index.asset.php';

		if ( ! file_exists( $asset_file ) ) {
			return;
		}

		$asset = include $asset_file;

		// Enqueue admin CSS.
		wp_enqueue_style(
			'nahidul-api-fetcher-admin',
			NAHIDUL_API_FETCHER_BUILD_URL . 'admin/style.css',
			array_filter(
				$asset['dependencies'],
				function ( $style ) {
					return wp_style_is( $style, 'registered' );
				}
			),
			$asset['version'],
		);

		// Enqueue admin JS.
		wp_enqueue_script(
			'nahidul-api-fetcher-admin',
			NAHIDUL_API_FETCHER_BUILD_URL . 'admin/index.js',
			$asset['dependencies'],
			$asset['version'],
			array(
				'in_footer' => true,
			)
		);

		wp_localize_script(
			'nahidul-api-fetcher-admin',
			'nahidulApiFetcher',
			array(
				'ajax_url'    => admin_url( 'admin-ajax.php' ),
				'ajax_action' => Ajax::AJAX_ACTION,
				'nonce'       => wp_create_nonce( Ajax::NONCE_ACTION ),
			)
		);
	}
}
