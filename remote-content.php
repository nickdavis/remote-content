<?php
/**
 * Plugin Name: Remote Content
 * Plugin URI: https://iamnickdavis.com
 * Description: WordPress plugin to help developers get remote content from Facebook, Instagram and Twitter in a standardised format
 * Version: 2.0.0
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

if ( ! defined( 'ND_REMOTE_CONTENT_DIR' ) ) {
	define( 'ND_REMOTE_CONTENT_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

// Load Autoloader class and register plugin and vendor namespaces.
require_once ND_REMOTE_CONTENT_DIR . 'src/Autoloader.php';
( new Autoloader() )
	->add_namespace( 'NickDavis\\RemoteContent', ND_REMOTE_CONTENT_DIR . 'src' )
	->add_namespace( '', ND_REMOTE_CONTENT_DIR . 'vendor/j7mbo/twitter-api-php' )
	->register();

