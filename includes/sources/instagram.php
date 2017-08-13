<?php
/**
 * Instagram
 *
 * @package     NickDavis\RemoteContent\Sources
 * @since       1.0.0
 * @author      Nick Davis
 * @link        https://iamnickdavis.com
 * @license     GNU General Public License 2.0+
 */

namespace NickDavis\RemoteContent\Sources;

function get_remote_content_clean_instagram( $data ) {
	return array(
		'image'       => esc_url( $data->data[0]->images->standard_resolution->url ),
		'profile_url' => 'https://www.instagram.com/' . esc_html( $data->data[0]->user->username ) . '/',
		'text'        => esc_html( $data->data[0]->caption->text ),
		'url'         => esc_url( $data->data[0]->link ),
		'username'    => esc_html( $data->data[0]->user->username ),
	);
}

/**
 * Fetches the latest Instagram post for the specified user as an object.
 *
 * @since 1.0.0
 *
 * @return object
 */
function fetch_remote_content_raw_instagram() {
	if (
		! defined( 'INSTAGRAM_ACCESS_TOKEN' ) &&
		! defined( 'INSTAGRAM_CLIENT_ID' ) &&
		! defined( 'INSTAGRAM_USER_ID' )

	) {
		return;
	}

	$user_id = INSTAGRAM_USER_ID; // https://www.instagram.com/username/?__a=1
	$api_url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?access_token=' . INSTAGRAM_ACCESS_TOKEN;

	$count = 1;

	$request = wp_safe_remote_get( add_query_arg( array(
		'client_id' => esc_html( INSTAGRAM_CLIENT_ID ),
		'count'     => absint( $count )
	), $api_url ) );

	if ( is_wp_error( $request ) ) {
		return false; // Bail early
	}

	$body = wp_remote_retrieve_body( $request );

	$data = json_decode( $body );

	return $data;
}
