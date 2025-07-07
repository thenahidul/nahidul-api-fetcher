<?php
/**
 * Helper functions for Nahidul API Fetcher.
 *
 * @package Nahidul_Api_Fetcher
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'nahidul_api_fetcher_template_part' ) ) {
	/**
	 * Loads and optionally returns a specified template part for the plugin.
	 *
	 * This function attempts to load a specific template file, checking for a custom
	 * theme override first and falling back to the plugin's default template directory
	 * if no override is found. The loaded template can optionally return its output
	 * instead of rendering it directly.
	 *
	 * @param string $folder_path    Optional. Subfolder path within the template directory.
	 *                               Defaults to an empty string.
	 * @param string $name           The template file's base name, without extension. Required.
	 * @param array $args            Optional. An associative array of variables to extract
	 *                               and make available to the template. Defaults to an
	 *                               empty array.
	 * @param bool $return_results   Optional. Whether to return the template output as
	 *                               a string instead of rendering it directly. Defaults to false.
	 *
	 * @return string|void Returns the template output if $return_results is true,
	 *                     otherwise outputs the template and returns nothing.
	 */
	function nahidul_api_fetcher_template_part( string $folder_path = '', string $name = '', array $args = array(), bool $return_results = false ) {
		if ( empty( $name ) ) {
			return;
		}

		if ( ! empty( $args ) && is_array( $args ) ) {
			extract( $args, EXTR_SKIP );
		}

		$folder_path = ! empty( $folder_path ) ? '/' . trim( $folder_path, '/' ) . '/' : '/';

		// Check the theme override first.
		$template = locate_template( array( 'nahidul-api-fetcher' . $folder_path . $name . '.php' ) );

		// Fallback to the plugin template.
		if ( ! $template ) {
			$template_path = NAHIDUL_API_FETCHER_PLUGIN_DIR . 'templates' . $folder_path . $name . '.php';

			if ( file_exists( $template_path ) ) {
				$template = $template_path;
			}
		}

		/**
		 * Filter the final template path.
		 *
		 * @since 1.0.0
		 *
		 * @param string $template     Full path to the template file.
		 * @param string $folder_path Folder path relative to /templates.
		 * @param string $name        Template file name without extension.
		 */
		$template = apply_filters( 'nahidul_api_fetcher_get_template_part', $template, $folder_path, $name );

		if ( $template ) {
			if ( $return_results ) {
				ob_start();
				include $template;
				return ob_get_clean();
			}

			include $template;
		}
	}
}
