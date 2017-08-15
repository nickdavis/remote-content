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
 * Class CachedContentSource.
 *
 * This is a "Decorator", that decorates any ContentSource with a caching
 * layer.
 *
 * This allows us to provide the caching functionality in way that is
 * transparent to both the content producer as well as the content consumer.
 *
 * @since   2.0.0
 *
 * @package NickDavis\RemoteContent
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class CachedContentSource implements ContentSource {

	const TRANSIENT_PREFIX = 'nd_remote_content_';
	const EXPIRATION       = HOUR_IN_SECONDS;

	/**
	 * Actual content source for which to cache the content.
	 *
	 * @since 2.0.0
	 *
	 * @var ContentSource
	 */
	private $source;

	/**
	 * Instantiate a CachedContentSource object.
	 *
	 * @since 2.0.0
	 *
	 * @param ContentSource $source The actual content source for which to
	 *                              cache the content.
	 */
	public function __construct( ContentSource $source ) {
		$this->source = $source;
	}

	/**
	 * Fetch the raw version of the latest content of a remote content source.
	 *
	 * @since 2.0.0
	 *
	 * @return mixed
	 */
	public function fetch_single() {
		$key = self::TRANSIENT_PREFIX . '_' . md5( get_class( $this->source ) );
		// Check cache first.
		$content = get_transient( $key );

		if ( false === $content ) {
			$content = $this->source->fetch_single();

			// Store in cache.
			set_transient( $key, $content, self::EXPIRATION );
		}

		return $content;
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
		return $this->source->clean( $content );
	}
}
