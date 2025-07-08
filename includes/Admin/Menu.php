<?php
/**
 * Menu functionality for Nahidul API Fetcher.
 *
 * @package Nahidul_Api_Fetcher
 */

namespace Nahidul\ApiFetcher\Admin;

use Nahidul\ApiFetcher\Api\Client;

defined( 'ABSPATH' ) || exit;

/**
 * Class responsible for creating and managing the admin menu interface for displaying API data.
 */
class Menu {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'in_admin_header', array( $this, 'add_header' ) );
		add_action( 'in_admin_footer', array( $this, 'add_footer' ) );
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
	}

	/**
	 * Output a custom header for the plugin admin page.
	 */
	public function add_header() {
		$screen = get_current_screen();

		// Only show on our plugin page.
		if ( empty( $screen ) || 'toplevel_page_nahidul-api-fetcher' !== $screen->id ) {
			return;
		}
		?>
		<div class="naf__header">
			<img class="naf__logo" src="<?php echo esc_url( NAHIDUL_API_FETCHER_PLUGIN_URL . 'build/images/logo.png' ) ?>" width="180px" alt="<?php echo esc_attr__( 'Nahidul API Fetcher', 'nahidul-api-fetcher' ); ?>">
		</div>
		<?php
	}

	/**
	 * Output a custom footer for the plugin admin page.
	 */
	public function add_footer() {
		$screen = get_current_screen();

		// Only show on our plugin page.
		if ( empty( $screen ) || 'toplevel_page_nahidul-api-fetcher' !== $screen->id ) {
			return;
		}
		?>
		<div class="flex flex-col items-center naf__footer">
			<p><?php esc_html_e( 'Made with ♥ by TheNahidul', 'nahidul-api-fetcher' ); ?></p>
			<ul class="flex justify-center items-center naf__footer-links">
				<li>
					<a href="https://www.linkedin.com/in/thenahidul" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'LinkedIn', 'nahidul-api-fetcher' ); ?></a>
				</li>
				<li>
					<a href="https://github.com/thenahidul" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'GitHub', 'nahidul-api-fetcher' ); ?></a>
				</li>
				<li>
					<a href="https://profiles.wordpress.org/thenahidul/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'WP', 'nahidul-api-fetcher' ); ?></a>
				</li>
			</ul>
		</div>
		<?php
	}

	/**
	 * Register the admin menu page.
	 */
	public function add_menu() {
		add_menu_page(
			esc_html__( 'Nahidul API Fetcher', 'nahidul-api-fetcher' ),
			esc_html__( 'Nahidul API Fetcher', 'nahidul-api-fetcher' ),
			'manage_options',
			NAHIDUL_API_FETCHER_MENU_SLUG,
			array( $this, 'render_page' ),
			'dashicons-database',
			60
		);
	}

	/**
	 * Render the admin page content.
	 */
	public function render_page() {
		$data = Client::get_data();
		?>
		<div class="wrap naf-wrapper">
			<form method="post" action="">
				<?php if ( is_wp_error( $data ) ) : ?>
					<div class="notice notice-error">
						<p><?php echo esc_html( $data->get_error_message() ); ?></p>
					</div>
				<?php else : ?>
					<div class="naf__table-container js-naf-table-container">
						<?php nahidul_api_fetcher_template_part( '', 'table', array( 'data' => $data ) ); ?>
						<p class="flex items-center justify-self-end">
							<button class="button button-primary naf__button js-naf-table-refresh-handler">
								<?php esc_html_e( 'Refresh Table', 'nahidul-api-fetcher' ); ?>
							</button>
						</p>
					</div>
				<?php endif; ?>
			</form>
		</div>
		<?php
	}
}
