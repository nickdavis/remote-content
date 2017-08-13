<?php
/**
 * Autoload
 *
 * @package     NickDavis\RemoteContent
 * @since       1.0.0
 * @author      Nick Davis
 * @link        https://iamnickdavis.com
 * @license     GNU General Public License 2.0+
 */

namespace NickDavis\RemoteContent;

/**
 * Autoload plugin files.
 *
 * @since 1.0.0
 *
 * @return void
 */
function autoload() {
	$files = array(
		'content-handler/content-handler',
		'sources/facebook',
		'sources/instagram',
		'sources/twitter',
	);

	foreach ($files as $file ) {
		include __DIR__ . '/' . $file . '.php';
	}
}
