# Nahidul API Fetcher
Contributors: TheNahidul
Tags: api, gutenberg, block
Requires at least: 6.0
Tested up to: 6.8
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Fetches data from a remote API and displays it in a table.

## Description

Fetches data from a remote API and displays it via AJAX, a Gutenberg block, an admin page, and WP-CLI.

## Features

* **Remote API Integration**: Fetches data from `https://miusage.com/v1/challenge/1/`
* **Smart Caching**: Implements 1-hour caching to prevent excessive API calls
* **AJAX Endpoint**: Public WordPress AJAX endpoint for data retrieval
* **Custom Gutenberg Block**: Display data in a customizable table format
* **Admin Dashboard**: WordPress admin page with data display and refresh functionality
* **WP CLI Command**: Command-line interface for forced data refresh
* **Internationalization**: Full translation support
* **Modern PHP Architecture**: Object-oriented design with PSR-4 autoloading

## Installation

1. Download the plugin files
2. Upload the `nahidul-api-fetcher` folder to your `/wp-content/plugins/` directory
3. Run `composer install` in the plugin directory to install dependencies
4. Activate the plugin through the 'Plugins' menu in WordPress

## Requirements

* WordPress 6.0 or higher
* PHP 7.4 or higher
* Composer (for development dependencies)

# Usage

## Gutenberg Block

1. Add a new block in the WordPress editor
2. Search for "Nahidul API Fetcher"
3. Insert the block to display the fetched data in a table format
4. Use block settings to toggle column visibility & refresh data

## Admin Dashboard

1. Navigate to **Dashboard > Nahidul API Fetcher** in WordPress admin
2. View the fetched data in a formatted table
3. Use the "Refresh Data" button to force update the cache

## REST Endpoint

The plugin creates a public REST API endpoint accessible at:
`/wp-json/nahidul-api-fetcher/v1/data/`
`/wp-json/nahidul-api-fetcher/v1/data/?refresh=true`

## WP CLI Command

Get data
`wp nahidul-api-fetcher data`
`wp nahidul-api-fetcher data --force` // Clear cached data and get new ones
`wp nahidul-api-fetcher data --show_col=name,date` // Show specific columns
`wp nahidul-api-fetcher data --show_col=name,date` // Hide specific columns

# Development

## Prerequisites

* Composer
* Node.js and npm (for block development)
* WordPress development environment

## Setup

1. Clone the repository
2. Install PHP dependencies: `composer install`,
3. `composer update`, `composer dump-autoload` (if needed )
3. Install JavaScript dependencies: `npm install`
4. Build assets: `npm run build` or `npm start` for development

## Code Standards

* PSR-4 autoloading
* WordPress coding standards
* Modern PHP practices (OOP, namespaces)
* Proper sanitization and validation
* Internationalization ready

## Security

* All data is properly sanitized and validated
* Uses WordPress nonces for admin actions
* Implements rate limiting through caching
* Follows WordPress security best practices

## Caching

The plugin implements intelligent caching:
* **Duration**: 1 hour (3600 seconds)
* **Storage**: WordPress transients
* **Override**: Available via WP CLI command or admin refresh button

## Internationalization

The plugin is fully translatable:
* Text domain: `nahidul-api-fetcher`
* POT file: `languages/nahidul-api-fetcher.pot`
* Translation functions: `__()`, `_e()`, `esc_html__()`

## Changelog

**1.0.0**
* Initial release
* Remote API integration
* Gutenberg block implementation
* Admin dashboard
* WP CLI command
* Caching system
* Internationalization support


## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Run tests and ensure code standards
5. Submit a pull request

## License

This plugin is licensed under the GPL v2 or later.

## Author

**Md Nahidul Islam**
* Plugin development with modern WordPress practices
* Focus on performance, security, and user experience
