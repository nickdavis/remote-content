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
use TwitterAPIExchange;

/**
 * Class Twitter.
 *
 * @since   2.0.0
 *
 * @package NickDavis\RemoteContent\ContentSource
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class Twitter implements ContentSource {

	/**
	 * Fetch the raw version of the latest content of a remote content source.
	 *
	 * @since 2.0.0
	 *
	 * @return mixed
	 */
	public function fetch_single() {
		if (
			! defined( 'TWITTER_OAUTH_ACCESS_TOKEN' ) ||
			! defined( 'TWITTER_OAUTH_ACCESS_TOKEN_SECRET' ) ||
			! defined( 'TWITTER_CONSUMER_KEY' ) ||
			! defined( 'TWITTER_CONSUMER_SECRET' ) ||
			! defined( 'TWITTER_USERNAME' )
		) {
			return;
		}

		$settings = array(
			'oauth_access_token'        => TWITTER_OAUTH_ACCESS_TOKEN,
			'oauth_access_token_secret' => TWITTER_OAUTH_ACCESS_TOKEN_SECRET,
			'consumer_key'              => TWITTER_CONSUMER_KEY,
			'consumer_secret'           => TWITTER_CONSUMER_SECRET,
		);

		$username = TWITTER_USERNAME;
		$limit    = 1;

		$url            = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		$getfield       = '?screen_name=' . $username . '&count=' . $limit;
		$request_method = 'GET';

		$twitter_instance = new TwitterAPIExchange( $settings );

		$query = $twitter_instance
			->setGetfield( $getfield )
			->buildOauth( $url, $request_method )
			->performRequest();

		$data = json_decode( $query );

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

		$username = TWITTER_USERNAME;

		// TODO: Validate data and account for edge cases.

		// TODO: Clean up and adapt to account for multiple elements.

		return array(
			'text'        => esc_html( $content[0]->text ),
			//'text_150'    => esc_html( mb_strimwidth( $content[0]->text, 0, 150, '...' ) ),
			'profile_url' => 'https://twitter.com/' . $username,
			'username'    => '@' . $username,
			'url'         => 'https://twitter.com/' . $username . '/status/' . (int) $content[0]->id,
		);
	}
}
