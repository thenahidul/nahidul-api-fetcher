<?php
/**
 * Registers custom REST API endpoints.
 *
 * @package Nahidul_Api_Fetcher
 */

namespace Nahidul\ApiFetcher\Rest;

use Nahidul\ApiFetcher\Api\Client;

defined( 'ABSPATH' ) || exit;

/**
 * Manages the registration of custom REST API endpoints.
 *
 * @package Nahidul_Api_Fetcher
 */
class Controller {

	const API_NAMESPACE = 'nahidul-api-fetcher/v1';

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Register REST routes.
	 */
	public function register_routes() {
		register_rest_route(
			self::API_NAMESPACE,
			'/data',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_data' ),
				'permission_callback' => array( $this, 'public_access' ),
				'args'                => array(
		            'refresh' => array(
		                'type'    => 'boolean',
		                'default' => false,
		            ),
		        ),
			)
		);
	}

	/**
	 * Handle GET request to return cached or fresh data.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_data( \WP_REST_Request $request ) {
		$refresh = filter_var( $request->get_param( 'refresh' ), FILTER_VALIDATE_BOOLEAN );
		$data    = Client::get_data( $refresh );

		if ( is_wp_error( $data ) ) {
			return new \WP_REST_Response(
				array(
					'success' => false,
					'message' => $data->get_error_message(),
				),
				500
			);
		}

		return rest_ensure_response( $data );
	}

	/**
	 * Allow public access to endpoints.
	 *
	 * @return bool
	 */
	public function public_access() {
		return true;
	}
}
