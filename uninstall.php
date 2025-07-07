<?php
/**
 * Uninstall script for Nahidul API Fetcher.
 *
 * @package Nahidul_Api_Fetcher
 */

defined( 'WP_UNINSTALL_PLUGIN' ) || exit;

// Delete cached data.
delete_transient( 'nahidul_api_fetcher_data' );
