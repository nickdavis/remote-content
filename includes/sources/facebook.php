<?php
/**
 * Facebook
 *
 * @package     NickDavis\RemoteContent\Sources
 * @since       1.0.0
 * @author      Nick Davis
 * @link        https://iamnickdavis.com
 * @license     GNU General Public License 2.0+
 */

namespace NickDavis\RemoteContent\Sources;

function get_remote_content_clean_facebook( $data ) {
	return array(
		'text'     => esc_html( $data->data[0]->message ),
		//'text_150' => esc_html( mb_strimwidth( $data->data[0]->message, 0, 150, '...' ) ),
		'url'      => 'https://www.facebook.com/' . $data->data[0]->id,
		//'username' => '',
	);
}

/**
 * Fetches the latest Facebook post for the specified user as an object.
 *
 * @link https://stackoverflow.com/a/35826425
 * @link https://gist.github.com/biojazzard/740551af0455c528f8a9
 *
 * @since 1.0.0
 *
 * @return object
 */
function fetch_remote_content_raw_facebook() {
	if (
		! defined( 'FACEBOOK_ACCESS_TOKEN' ) &&
		! defined( 'FACEBOOK_CLIENT_ID' ) &&
		! defined( 'FACEBOOK_PAGE_ID' )
	) {
		return;
	}

	$page_id = FACEBOOK_PAGE_ID;
	$api_url = 'https://graph.facebook.com/' . $page_id . '/posts?access_token=' . FACEBOOK_ACCESS_TOKEN;

	$count = 1;

	$request = wp_safe_remote_get( add_query_arg( array(
		'client_id' => esc_html( FACEBOOK_CLIENT_ID ),
		'count'     => absint( $count )
	), $api_url ) );

	if ( is_wp_error( $request ) ) {
		return false; // Bail early
	}

	$body = wp_remote_retrieve_body( $request );

	$data = json_decode( $body );

	return $data;
}
