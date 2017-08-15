<?php
/**
 * Remote Content.
 *
 * @package   NickDavis\RemoteContent
 * @since     2.0.0
 * @author    Alain Schlesser <alain.schlesser@gmail.com>
 * @license   MIT
 * @link      https://www.alainschlesser.com/
 * @copyright 2017 Alain Schlesser
 */

namespace NickDavis\RemoteContent\ContentSource;

use NickDavis\RemoteContent\ContentSource;

/**
 * Class Instagram.
 *
 * @since   2.0.0
 *
 * @package NickDavis\RemoteContent\ContentSource
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class Instagram implements ContentSource {

	/**
	 * Fetch the raw version of the latest content of a remote content source.
	 *
	 * @since 2.0.0
	 *
	 * @return mixed
	 */
	public function fetch_single() {
		if (
			! defined( 'INSTAGRAM_ACCESS_TOKEN' ) ||
			! defined( 'INSTAGRAM_CLIENT_ID' ) ||
			! defined( 'INSTAGRAM_USER_ID' )

		) {
			return;
		}

		$user_id = INSTAGRAM_USER_ID; // https://www.instagram.com/username/?__a=1
		$api_url = 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?access_token=' . INSTAGRAM_ACCESS_TOKEN;

		$count = 1;

		$request = wp_safe_remote_get( add_query_arg( array(
			'client_id' => esc_html( INSTAGRAM_CLIENT_ID ),
			'count'     => absint( $count ),
		), $api_url ) );

		if ( is_wp_error( $request ) ) {
			return false; // Bail early
		}

		$body = wp_remote_retrieve_body( $request );

		$data = json_decode( $body );

		return $data;
	}

	/**
	 * Clean the raw content that was fetched from a remote content source.
	 *
	 * @since 2.0.0
	 *
	 * @param $content
	 *
	 * @return array
	 */
	public function clean( $content ) {

		// TODO: Validate data and account for edge cases.

		// TODO: Clean up and adapt to account for multiple elements.

		return array(
			'image'       => esc_url( $content->data[0]->images->standard_resolution->url ),
			'profile_url' => 'https://www.instagram.com/' . esc_html( $content->data[0]->user->username ) . '/',
			'text'        => esc_html( $content->data[0]->caption->text ),
			'url'         => esc_url( $content->data[0]->link ),
			'username'    => esc_html( $content->data[0]->user->username ),
		);
	}
}
