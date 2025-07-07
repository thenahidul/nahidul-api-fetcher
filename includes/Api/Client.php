<?php
/**
 * Handles remote API requests and caching.
 *
 * @package Nahidul_Api_Fetcher
 */

namespace Nahidul\ApiFetcher\Api;

defined( 'ABSPATH' ) || exit;

/**
 * Handles storing and retrieving data from a remote API.
 */
class Client {

	/**
	 * Store data from a remote API in a transient.
	 *
	 * @param string $url Optional. Remote API URL. Defaults to constant.
	 * @return void
	 */
	public static function store_data( string $url = NAHIDUL_API_FETCHER_REMOTE_URL ): void {
		$response = wp_remote_get( $url );

		if ( is_wp_error( $response ) ) {
			return;
		}

		$body = wp_remote_retrieve_body( $response );
		$data = json_decode( $body, true );

		if ( ! is_array( $data ) ) {
			return;
		}

		/**
		 * Filter the API data before storing it in the transient.
		 *
		 * @param array $data API response data.
		 */
		$data = apply_filters( 'nahidul_api_fetcher_before_store', $data );

		set_transient( NAHIDUL_API_FETCHER_TRANSIENT_KEY, $data, HOUR_IN_SECONDS );
	}

	/**
	 * Get data from cache or fetch from remote API.
	 *
	 * @param bool $force Whether to force refresh from a remote API.
	 * @return array|\WP_Error
	 */
	public static function get_data( bool $force = false ) {
		if ( $force ) {
			delete_transient( NAHIDUL_API_FETCHER_TRANSIENT_KEY );
			self::store_data();
		}

		$cached_data = get_transient( NAHIDUL_API_FETCHER_TRANSIENT_KEY );

		if ( false !== $cached_data ) {
			return $cached_data;
		}

		// Try to fetch and store again if cache is empty.
		self::store_data();
		$cached_data = get_transient( NAHIDUL_API_FETCHER_TRANSIENT_KEY );

		if ( false === $cached_data ) {
			return new \WP_Error(
				'data_retrieval_failed',
				esc_html__( 'Failed to retrieve or store data.', 'nahidul-api-fetcher' )
			);
		}

		return $cached_data;
	}
}
