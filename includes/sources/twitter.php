<?php
/**
 * Twitter
 *
 * Uses the twitter-api-php wrapper via the /vendor folder of this plugin.
 *
 * @link https://github.com/J7mbo/twitter-api-php
 *
 * @package     NickDavis\RemoteContent\Sources
 * @since       1.0.0
 * @author      Nick Davis
 * @link        https://iamnickdavis.com
 * @license     GNU General Public License 2.0+
 */

namespace NickDavis\RemoteContent\Sources;

use TwitterAPIExchange;

function get_remote_content_clean_twitter( $data ) {
	$username = TWITTER_USERNAME;

	return array(
		'text'        => esc_html( $data[0]->text ),
		//'text_150'    => esc_html( mb_strimwidth( $data[0]->text, 0, 150, '...' ) ),
		'profile_url' => 'https://twitter.com/' . $username,
		'username'    => '@' . $username,
		'url'         => 'https://twitter.com/' . $username . '/status/' . (int) $data[0]->id,
	);
}

/**
 * Fetches the latest Twitter post for the specified user as an object.
 *
 * @since 1.0.0
 *
 * @return object
 */
function fetch_remote_content_raw_twitter() {
	if (
		! defined( 'TWITTER_OAUTH_ACCESS_TOKEN' ) &&
		! defined( 'TWITTER_OAUTH_ACCESS_TOKEN_SECRET' ) &&
		! defined( 'TWITTER_CONSUMER_KEY' ) &&
		! defined( 'TWITTER_CONSUMER_SECRET' ) &&
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
