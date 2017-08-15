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
 * Class Facebook.
 *
 * @since   2.0.0
 *
 * @package NickDavis\RemoteContent\ContentSource
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class Facebook implements ContentSource {

	/**
	 * Fetch the raw version of the latest content of a remote content source.
	 *
	 * @since 2.0.0
	 *
	 * @return mixed
	 */
	public function fetch_single() {
		if (
			! defined( 'FACEBOOK_ACCESS_TOKEN' ) ||
			! defined( 'FACEBOOK_CLIENT_ID' ) ||
			! defined( 'FACEBOOK_PAGE_ID' )
		) {
			return;
		}

		$page_id = FACEBOOK_PAGE_ID;
		$api_url = 'https://graph.facebook.com/' . $page_id . '/posts?access_token=' . FACEBOOK_ACCESS_TOKEN;

		$count = 1;

		$request = wp_safe_remote_get( add_query_arg( array(
			'client_id' => esc_html( FACEBOOK_CLIENT_ID ),
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
			'text' => esc_html( $content->data[0]->message ),
			'url'  => 'https://www.facebook.com/' . $content->data[0]->id,
		);
	}
}
