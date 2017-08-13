<?php
/**
 * Description.
 *
 * @package     ${NAMESPACE}.
 * @since       1.0.0
 * @author      Nick Davis
 * @link        https://iamnickdavis.com
 * @license     GNU General Public License 2.0+
 */

namespace NickDavis\RemoteContent\ContentHandler;

function get_remote_content( $source, $raw = false ) {
	$data = get_remote_content_raw( $source );

	if ( empty( $data ) ) {
		return;
	}

	if ( true === $raw ) {
		return $data;
	}

	$content = '\NickDavis\RemoteContent\Sources\get_remote_content_clean_' . $source;

	return $content( $data );
}

/**
 * Returns the remote content data as an object from the WordPress transient cache.
 *
 * @param string $source slug of social network name
 *
 * @return mixed
 */
function get_remote_content_raw( $source ) {
	// Check cache first.
	$content = get_transient( TRANSIENT_PREFIX . '_' . $source );

	if ( false === $content ) {
		// No cached data, fetch through API.
		$fetch_remote_content = '\NickDavis\RemoteContent\Sources\fetch_remote_content_raw_' . $source;
		$content              = $fetch_remote_content();
		// Store in cache.
		set_transient( TRANSIENT_PREFIX . '_' . $source, $content, EXPIRATION );
	}

	return $content;
}
