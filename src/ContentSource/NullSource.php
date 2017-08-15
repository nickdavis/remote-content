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

final class NullSource implements ContentSource {

	/**
	 * Fetch the raw version of the latest content of a remote content source.
	 *
	 * @since 2.0.0
	 *
	 * @return mixed
	 */
	public function fetch_single() {
		return [];
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
		return [];
	}
}
