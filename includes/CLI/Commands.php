<?php
/**
 * WP CLI Commands for Nahidul API Fetcher.
 *
 * @package Nahidul_Api_Fetcher
 */

namespace Nahidul\ApiFetcher\CLI;

use Nahidul\ApiFetcher\Api\Client;
use WP_CLI;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Manages Nahidul API Fetcher operations via WP-CLI.
 */
class Commands {

	/**
	 * Constructor
	 */
	public function __construct() {
		// Register commands immediately if WP-CLI is available
		if ( defined( 'WP_CLI' ) && WP_CLI ) {
			$this->register_commands();
		}
	}

	/**
	 * Show basic information about the Nahidul API Fetcher plugin.
	 *
	 * ## EXAMPLES
	 *
	 *     wp nahidul-api-fetcher info
	 *
	 * @when after_wp_load
	 */
	public function info() {
		WP_CLI::line( '' );
		WP_CLI::log( esc_html__( 'Nahidul API Fetcher Plugin Info', 'nahidul-api-fetcher' ) );
		WP_CLI::line( str_repeat( '-', 40 ) );

		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugin_data = get_plugin_data( NAHIDUL_API_FETCHER_PLUGIN_FILE, false, false );

		WP_CLI::line( '📛 ' . esc_html__( 'Name: ', 'nahidul-api-fetcher' ) . ( $plugin_data['Name'] ?? '' ) );
		WP_CLI::line( '📦 ' . esc_html__( 'Version: ', 'nahidul-api-fetcher' ) . ( $plugin_data['Version'] ?? '' ) );
		WP_CLI::line( '👨‍💻 ' . esc_html__( 'Author: ', 'nahidul-api-fetcher' ) . ( $plugin_data['Author'] ?? '' ) );
		WP_CLI::line( '🔗 ' . esc_html__( 'Plugin URI: ', 'nahidul-api-fetcher' ) . ( $plugin_data['PluginURI'] ?? '' ) );
		WP_CLI::line( '📝 ' . esc_html__( 'Description: ', 'nahidul-api-fetcher' ) . ( $plugin_data['Description'] ?? '' ) );

		WP_CLI::line( '' );
	}

	/**
	 * Fetch and display remote API data.
	 *
	 * ## OPTIONS
	 *
	 * [--force]
	 * : Force refreshes the API data bypassing the cached version.
	 *
	 * ## EXAMPLES
	 *
	 *     wp nahidul-api-fetcher fetch
	 *     wp nahidul-api-fetcher fetch --force
	 *
	 * @when after_wp_load
	 */
	/**
	 * Show the API data in a table format with optional column filters.
	 *
	 * ## OPTIONS
	 *
	 * [--force]
	 * : Force refresh the API data.
	 *
	 * [--show_col=<columns>]
	 * : Comma-separated list of column keys to include (e.g. id,fname,email).
	 *
	 * [--hide_col=<columns>]
	 * : Comma-separated list of column keys to exclude.
	 *
	 * ## EXAMPLES
	 *
	 *     wp nahidul-api-fetcher data --force
	 *     wp nahidul-api-fetcher data --show_col=id,fname
	 *     wp nahidul-api-fetcher data --hide_col=email,date
	 *
	 * @when after_wp_load
	 */
	public function data( $args, $assoc_args ) {
		$force     = isset( $assoc_args['force'] ) && $assoc_args['force'];
		$show_cols = isset( $assoc_args['show_col'] ) ? explode( ',', $assoc_args['show_col'] ) : array();
		$hide_cols = isset( $assoc_args['hide_col'] ) ? explode( ',', $assoc_args['hide_col'] ) : array();

		WP_CLI::line( '' );

		if ( $force ) {
			WP_CLI::log( '🔄 ' . esc_html__( 'Forcing data refresh...', 'nahidul-api-fetcher' ) );
		} else {
			WP_CLI::log( '🚀 ' . esc_html__( 'Fetching cached data (if available)...', 'nahidul-api-fetcher' ) );
		}

		$data = Client::get_data( $force );

		if ( is_wp_error( $data ) ) {
			WP_CLI::error( $data->get_error_message() );
		}

		$rows = $data['data']['rows'] ?? array();

		if ( empty( $rows ) ) {
			WP_CLI::warning( esc_html__( 'No data found to display.', 'nahidul-api-fetcher' ) );
			return;
		}

		// Define the full column map (key => label).
		$columns = array(
			'id'    => 'ID',
			'fname' => 'First Name',
			'lname' => 'Last Name',
			'email' => 'Email',
			'date'  => 'Date',
		);

		// Determine final set of keys to include.
		if ( ! empty( $show_cols ) ) {
			$columns = array_intersect_key( $columns, array_flip( $show_cols ) );
		} elseif ( ! empty( $hide_cols ) ) {
			$columns = array_diff_key( $columns, array_flip( $hide_cols ) );
		}

		// Format rows based on filtered columns.
		$table = array();

		foreach ( $rows as $row ) {
			$item = array();

			foreach ( $columns as $key => $label ) {
				if ( $key === 'date' ) {
					$item[ $label ] = ! empty( $row['date'] ) ? date_i18n( get_option( 'date_format' ), intval( $row['date'] ) ) : '';
				} else {
					$item[ $label ] = $row[ $key ] ?? '';
				}
			}

			$table[] = $item;
		}

		WP_CLI::line( '' );
		WP_CLI::success( esc_html__( 'Data retrieved successfully.', 'nahidul-api-fetcher' ) );

		// Show final output
		WP_CLI\Utils\format_items( 'table', $table, array_values( $columns ) );
	}

	/**
	 * Registers the WP-CLI commands.
	 */
	public function register_commands() {
		if ( ! class_exists( 'WP_CLI' ) ) {
			return;
		}

		WP_CLI::add_command( 'nahidul-api-fetcher', $this );
	}
}
