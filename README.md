=== Nahidul API Fetcher ===
Contributors: thenahidul
Tags: api, gutenberg, block
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Fetches data from a remote API and displays it in a table.

== Description ==

Fetches data from a remote API and displays it via AJAX, a Gutenberg block, an admin page, and WP-CLI.

== Features ==

* **Remote API Integration**: Fetches data from `https://miusage.com/v1/challenge/1/`
* **Smart Caching**: Implements 1-hour caching to prevent excessive API calls
* **AJAX Endpoint**: Public WordPress AJAX endpoint for data retrieval
* **Custom Gutenberg Block**: Display data in a customizable table format
* **Admin Dashboard**: WordPress admin page with data display and refresh functionality
* **WP CLI Command**: Command-line interface for forced data refresh
* **Internationalization**: Full translation support
* **Modern PHP Architecture**: Object-oriented design with PSR-4 autoloading

== Installation ==

1. Download the plugin files
2. Upload the `nahidul-api-fetcher` folder to your `/wp-content/plugins/` directory
3. Run `composer install` in the plugin directory to install dependencies
4. Activate the plugin through the 'Plugins' menu in WordPress

== Requirements ==

* WordPress 5.0 or higher
* PHP 7.4 or higher
* Composer (for development dependencies)

== Usage ==

= Gutenberg Block =

1. Add a new block in the WordPress editor
2. Search for "Nahidul API Data"
3. Insert the block to display the fetched data in a table format
4. Use block settings to toggle column visibility

= Admin Dashboard =

1. Navigate to **Dashboard > Nahidul API Fetcher** in WordPress admin
2. View the fetched data in a formatted table
3. Use the "Refresh Data" button to force update the cache

= AJAX Endpoint =

The plugin creates a public AJAX endpoint accessible at:
`/wp-admin/admin-ajax.php?action=nahidul_get_api_data`

= WP CLI Command =

Force refresh the cached data:
`wp nahidul-api refresh`

== API Endpoint ==

The plugin fetches data from:
* **URL**: `https://miusage.com/v1/challenge/1/`
* **Method**: GET
* **Caching**: 1 hour (3600 seconds)
* **Format**: JSON

== Development ==

= Prerequisites =

* Composer
* Node.js and npm (for block development)
* WordPress development environment

= Setup =

1. Clone the repository
2. Install PHP dependencies: `composer install`
3. Install JavaScript dependencies: `npm install`
4. Build assets: `npm run build`

= Code Standards =

* PSR-4 autoloading
* WordPress coding standards
* Modern PHP practices (OOP, namespaces)
* Proper sanitization and validation
* Internationalization ready

== Security ==

* All data is properly sanitized and validated
* Uses WordPress nonces for admin actions
* Implements rate limiting through caching
* Follows WordPress security best practices

== Caching ==

The plugin implements intelligent caching:
* **Duration**: 1 hour (3600 seconds)
* **Storage**: WordPress transients
* **Override**: Available via WP CLI command or admin refresh button

== Internationalization ==

The plugin is fully translatable:
* Text domain: `nahidul-api-fetcher`
* POT file: `languages/nahidul-api-fetcher.pot`
* Translation functions: `__()`, `_e()`, `esc_html__()`

== Hooks and Filters ==

= Actions =
* `nahidul_api_fetcher_data_refreshed` - Fired when data is refreshed
* `nahidul_api_fetcher_cache_cleared` - Fired when cache is cleared

= Filters =
* `nahidul_api_fetcher_cache_duration` - Modify cache duration
* `nahidul_api_fetcher_api_url` - Modify API endpoint URL
* `nahidul_api_fetcher_data` - Filter fetched data before processing

== Error Handling ==

The plugin includes comprehensive error handling:
* API connection failures
* Invalid JSON responses
* Network timeouts
* WordPress errors

== Troubleshooting ==

= Common Issues =

1. **Data not loading**: Check if the API endpoint is accessible
2. **Cache not updating**: Use WP CLI command to force refresh
3. **Block not appearing**: Ensure Gutenberg is enabled
4. **Permission errors**: Verify file permissions

= Debug Mode =

Enable WordPress debug mode to see detailed error messages:
`define('WP_DEBUG', true);`
`define('WP_DEBUG_LOG', true);`

== Screenshots ==

1. Admin dashboard showing fetched API data
2. Gutenberg block in the editor
3. Block settings panel with column visibility options
4. Frontend display of the data table

== Frequently Asked Questions ==

= How often does the plugin fetch data from the API? =

The plugin fetches data from the remote API maximum once per hour. It uses WordPress transients to cache the data and prevent excessive API calls.

= Can I force refresh the data? =

Yes, you can force refresh the data using either:
* The "Refresh Data" button in the admin dashboard
* The WP CLI command: `wp nahidul-api refresh`

= Is the AJAX endpoint secure? =

The AJAX endpoint is public and doesn't require authentication. However, it only provides read-only access to cached data and implements rate limiting through caching.

= Can I customize the data display? =

Yes, the Gutenberg block includes settings to toggle column visibility. You can also use the provided hooks and filters to customize the data processing and display.

== Changelog ==

= 1.0.0 =
* Initial release
* Remote API integration
* Gutenberg block implementation
* Admin dashboard
* WP CLI command
* Caching system
* Internationalization support

== Upgrade Notice ==

= 1.0.0 =
Initial release of Nahidul API Fetcher plugin.

== Contributing ==

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests and ensure code standards
5. Submit a pull request

== License ==

This plugin is licensed under the GPL v2 or later.

== Support ==

For support and bug reports, please use the plugin's support forum or contact the developer.

== Author ==

**Nahidul Islam**
* Plugin development with modern WordPress practices
* Focus on performance, security, and user experience
