<?php
/**
 * Handles the registration of WordPress blocks for the plugin.
 */
namespace Nahidul\ApiFetcher\Admin;

defined( 'ABSPATH' ) || exit;

/**
 * Manages the registration and initialization of custom WordPress blocks.
 */
class Block {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'block_init' ) );
	}

	/**
	 * Register blocks using the metadata from the `block.json` files.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	public function block_init() {
		/**
		 * Filter blocks
		 *
		 * @since 1.0.0
		 *
		 * @var array $blocks
		 */
		$blocks = apply_filters(
			'nahidul_api_fetcher_all_blocks',
			array(
				'api-fetcher',
			)
		);

		foreach ( $blocks as $block ) {
			register_block_type( NAHIDUL_API_FETCHER_PLUGIN_DIR . 'build/blocks/' . $block );
		}
	}
}
