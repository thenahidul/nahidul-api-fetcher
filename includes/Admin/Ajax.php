<?php
/**
 * Handles AJAX actions related to the Nahidul API Fetcher plugin in the admin interface.
 */

namespace Nahidul\ApiFetcher\Admin;

use Nahidul\ApiFetcher\Api\Client;

defined( 'ABSPATH' ) || exit;

/**
 * Handles AJAX requests within the plugin.
 *
 * Provides functionalities to handle secured AJAX callbacks
 * and interact with client-side components for the plugin.
 */
class Ajax {

	const AJAX_ACTION = 'nahidul_api_fetcher_refresh';

	const NONCE_ACTION = 'nahidul_api_fetcher';

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'wp_ajax_' . self::AJAX_ACTION, array( $this, 'refresh_table_data' ) );
	}

	/**
	 * Refreshes the table data via an AJAX request.
	 *
	 * This method checks the AJAX nonce and user capabilities, retrieves updated data,
	 * and returns it as rendered HTML. If there are errors during data retrieval,
	 * an appropriate error message is sent in the response.
	 *
	 * @return void Outputs a JSON response with updated table HTML on success,
	 * or an error message on failure.
	 */
	public function refresh_table_data() {
		check_ajax_referer( self::NONCE_ACTION, 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( __( 'You do not have sufficient permissions to perform this action.', 'nahidul-api-fetcher') );
		}

		$data = Client::get_data( true );

		if ( is_wp_error( $data ) ) {
			wp_send_json_error( esc_html( $data->get_error_message() ) );
		}

		ob_start();
		nahidul_api_fetcher_template_part( '', 'table', array( 'data' => $data ) );
		$html = ob_get_clean();

		wp_send_json_success( array( 'html' => $html ) );
	}
}
