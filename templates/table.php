<?php
/**
 * Table view template.
 *
 * @package Nahidul_Api_Fetcher
 *
 * @var array $args API data
 */

defined( 'ABSPATH' ) || exit;

$data    = $args['data'] ?? array();
$columns = $args['columns'] ?? array();

if ( empty( $data ) || ! is_array( $data ) ) {
	return;
}

$title   = $data['title'] ?? '';
$table   = $data['data'] ?? array();
$headers = $table['headers'] ?? array();
$rows    = $table['rows'] ?? array();

$should_hide_column = ! empty( $columns );

// Map header labels to field keys.
$field_map = array(
	'ID'         => 'id',
	'First Name' => 'fname',
	'Last Name'  => 'lname',
	'Email'      => 'email',
	'Date'       => 'date',
);

$invalid = empty( $data ) || ! is_array( $data ) || empty( $headers ) || ! is_array( $headers ) || empty( $rows ) || ! is_array( $rows );
if ( $invalid ) :
	?>
	<div class="notice notice-error">
		<p><?php esc_html_e( 'No valid data found!', 'nahidul-api-fetcher' ); ?></p>
	</div>
	<?php return;
endif;
?>
<?php if ( ! empty( $title ) ) : ?>
	<h2>
		<?php
		/**
		 * Filter to modify the title of the table.
		 *
		 * @since 1.0.0
		 *
		 * @param string $title.
		 * @param array $table
		 */
		echo esc_html( apply_filters( 'nahidul_api_fetcher_table_title', $title, $table ) );
		?>
	</h2>
<?php endif; ?>

<?php
/**
 * Fires before the Table.
 *
 * @since 1.0.0
 *
 * @param array $table
 */
do_action( 'nahidul_api_fetcher_table_before_table', $table );
?>
<table class="widefat striped naf__table">
	<thead>
		<tr>
			<?php foreach ( $headers as $header ) :
				$column = $field_map[ $header ] ?? null;

				if ( ! $should_hide_column || in_array( $column, $columns, true ) ) : ?>
					<th><?php echo esc_html( $header ); ?></th>
				<?php endif;
			endforeach; ?>
		</tr>
	</thead>

	<tbody>
		<?php foreach ( $rows as $row ) : ?>
			<tr>
				<?php foreach ( $row as $column => $value ) :
					if ( ! $should_hide_column || in_array( $column, $columns, true ) ) : ?>
						<td>
							<?php
							if ( $column === 'date' ) {
								echo esc_html( date_i18n( get_option( 'date_format' ), intval( $value ) ) );
							} else {
								echo esc_html( $value );
							}
							?>
						</td>
					<?php endif;
				endforeach; ?>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php
/**
 * Fires after the Table.
 *
 * @since 1.0.0
 *
 * @param array $table
 */
do_action( 'nahidul_api_fetcher_table_after_table', $table );
