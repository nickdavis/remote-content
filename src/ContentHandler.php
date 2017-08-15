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

namespace NickDavis\RemoteContent;

use NickDavis\RemoteContent\ContentSource\CachedContentSource;

/**
 * Class ContentHandler.
 *
 * @since   2.0.0
 *
 * @package NickDavis\RemoteContent
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
final class ContentHandler {

	/**
	 * Known content sources.
	 *
	 * @since 2.0.0
	 */
	const SOURCES = [
		'facebook'  => ContentSource\Facebook::class,
		'instagram' => ContentSource\Instagram::class,
		'twitter'   => ContentSource\Twitter::class,
	];

	/**
	 * Store the instances of the content source objects.
	 *
	 * @var array
	 *
	 * @since 2.0.0
	 */
	private static $instances = [];

	/**
	 * Fetch the raw remote content.
	 *
	 * @since 2.0.0
	 *
	 * @return mixed
	 */
	public static function fetch_single_raw( $source ) {
		return self::get_source( $source )->fetch_single();
	}

	/**
	 * Fetch the remote content.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	public static function fetch_single( $source ) {
		$source_object = self::get_source( $source );

		$raw_content = $source_object->fetch_single();

		if ( empty( $raw_content ) ) {
			return '(technical problem while fetching remote content)';
		}

		return $source_object->clean( $raw_content );
	}

	/**
	 * Get the instance of the content source object.
	 *
	 * Instantiates a fresh instance as needed.
	 *
	 * It falls back to a `ContentSource\NullSource` if the source is unknown.
	 *
	 * @since 2.0.0
	 *
	 * @param string $source Source to get.
	 *
	 * @return ContentSource
	 */
	private static function get_source( $source ) {
		if ( ! array_key_exists( $source, self::$instances ) ) {
			$class = array_key_exists( $source,
				self::SOURCES )
				? self::SOURCES[ $source ]
				: ContentSource\NullSource::class;

			$source_object        = new $class();
			$cached_source_object = new CachedContentSource( $source_object );

			self::$instances[ $source ] = $cached_source_object;
		}

		return self::$instances[ $source ];
	}
}
