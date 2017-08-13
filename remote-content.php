<?php
/**
 * Plugin Name: Remote Content
 * Plugin URI: https://iamnickdavis.com
 * Description: WordPress plugin to help developers get remote content from Facebook, Instagram and Twitter in a standardised format
 * Version: 0.1.0
 * Author: Nick Davis
 * Author URI: https://iamnickdavis.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation.  You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 */

namespace NickDavis\RemoteContent;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheatin&#8217; uh?' );
}

/**
 * Setup the plugin's constants.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_constants() {
	$plugin_url = plugin_dir_url( __FILE__ );
	if ( is_ssl() ) {
		$plugin_url = str_replace( 'http://', 'https://', $plugin_url );
	}

	define( 'ND_REMOTE_CONTENT_VERSION', '0.1.0' );
	define( 'ND_REMOTE_CONTENT_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
	define( 'ND_REMOTE_CONTENT_URL', $plugin_url );
	define( 'ND_REMOTE_CONTENT_FILE', __FILE__ );
}

/**
 * Initialize the plugin hooks
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_hooks() {
	register_activation_hook( __FILE__, __NAMESPACE__ . '\activate_plugin' );
	register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate_plugin' );
}

/**
 * Plugin activation handler.
 *
 * @since 1.0.0
 *
 * @return void
 */
function activate_plugin() {
}

/**
 * The plugin is deactivating.  Delete out the rewrite rules option.
 *
 * @since 1.0.0
 *
 * @return void
 */
function deactivate_plugin() {
}

/**
 * Initializes vendor files.
 *
 * @todo The class exists doesn't actually work in that it will load the file
 * twice, if already set elsewhere
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_vendor() {
	if ( ! class_exists( 'TwitterAPIExchange' ) ) {
		require_once ND_REMOTE_CONTENT_DIR . 'vendor/j7mbo/twitter-api-php/TwitterAPIExchange.php';
	}
}

/**
 * Initializes the config files.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_config() {
}

/**
 * Kick off the plugin by initializing the plugin files.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_autoloader() {
	require_once( 'includes/autoload.php' );

	autoload();
}

/**
 * Launch the plugin
 *
 * @since 1.0.0
 *
 * @return void
 */
function launch() {
	init_vendor();
	init_config();
	init_autoloader();
}

init_constants();
init_hooks();
launch();
