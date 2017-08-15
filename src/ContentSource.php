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

/**
 * Interface ContentSource.
 *
 * This is the "contract" that the ContentHandler has with all content sources.
 * As long as both parties agree to this contract, the rest of the code should
 * just work.
 *
 * @since   2.0.0
 *
 * @package NickDavis\RemoteContent
 * @author  Alain Schlesser <alain.schlesser@gmail.com>
 */
interface ContentSource {

	/**
	 * Fetch the raw version of the latest content of a remote content source.
	 *
	 * @since 2.0.0
	 *
	 * @return mixed
	 */
	public function fetch_single();

	/**
	 * Clean the raw content that was fetched from a remote content source.
	 *
	 * @since 2.0.0
	 *
	 * @param $content
	 *
	 * @return array
	 */
	public function clean( $content );

	// TODO: Add a `fetch( $limit )` ?
}
