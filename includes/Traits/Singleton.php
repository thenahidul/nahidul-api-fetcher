<?php
/**
 * Singleton functionality for Nahidul API Fetcher.
 *
 * @package Nahidul_Api_Fetcher
 */

namespace Nahidul\ApiFetcher\Traits;

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Trait for a Singleton pattern.
 */
trait Singleton {
	/**
	 * Singleton instance.
	 *
	 * @var null
	 */
	protected static $instance = null;

	/**
	 * Get the singleton instance.
	 * @return null
	 */
	public static function get_instance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * Prevent direct instantiation.
	 */
	protected function __construct() {}

	/**
	 * Prevent cloning of the instance.
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function __clone() {
		throw new \Exception( esc_html__( 'Cloning is not allowed.', 'nahidul-api-fetcher') );
	}

	/**
	 * Prevent un-serializing of the instance.
	 *
	 * @return mixed
	 * @throws Exception
	 */
	public function __wakeup() {
		throw new \Exception( esc_html__( 'Un-serializing is not allowed.', 'nahidul-api-fetcher') );
	}
}
