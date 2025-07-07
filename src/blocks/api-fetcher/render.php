<?php
/**
 * Server-rendered output for API Fetcher block.
 *
 * @package Nahidul_ApiFetcher
 *
 * @type array $attributes Block attributes.
 * @type array $content Block content.
 * @type array $block Block instance.
 */

use Nahidul\ApiFetcher\Api\Client;

$data = ! empty( $attributes['data'] ) ? $attributes['data'] : Client::get_data();

ob_start();

nahidul_api_fetcher_template_part(
	'', 'table',
	array(
		'data'    => $data,
		'columns' => $attributes['columns'] ?? array(),
	)
);

$table = ob_get_clean();

if ( ! empty( $table ) ) :
	?>
	<div <?php echo wp_kses_data( get_block_wrapper_attributes() ); ?>>
		<?php echo wp_kses_post( $table ); ?>
	</div>
	<?php
endif;
