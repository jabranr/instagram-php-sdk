<?php

/**
 * @package: PHP client for Instagram API
 * @author: hello@jabran.me
 * @license: MIT License
 *
 * Copyright (c) 2013-2014 Jabran Rafique
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy,
 * modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software
 * is furnished to do so, subject to the following conditions: The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED,
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE
 * FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
 * ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Instagram;

class InstagramClient extends InstagramClientBase	{

	/**
	 * @override: Default construct method
	 */
	public function __construct( $config = array() )	{
		return parent::__construct( $config );
	}


	/**
	 * Get media using ID
	 */
	public function media( $id = 0 ) {

		/**
		 * Return if no ID provided
		 */
		if ( ! $id ) return;


		/**
		 * Throw exception if no valid access token
		 */
		if ( ! $this->access_token )
			throw new Exception( 'Invalid access token.' );


		/**
		 * Set request parameters
		 */
		$query = array(
				'access_token' => $this->access_token
			);


		/**
		 * Set CURL request URL
		 */
		$options = array(
				'url' => $this->endpoint . 'media/' . ( (int) $id ) . '?' . http_build_query( $query )
			);


		/**
		 * Return response
		 */
		return static::_curl( $options );

	}


	/**
	 * Get popular media
	 */
	public function popularMedia( $count = 30 )	{

		/**
		 * Throw exception if no valid access token
		 */
		if ( ! $this->access_token )
			throw new Exception( 'Invalid access token.' );


		/**
		 * Set request parameters
		 */
		$query = array(
				'access_token' => $this->access_token,
				'count' => (int) $count
			);


		/**
		 * Set CURL request URL
		 */
		$options = array(
				'url' => $this->endpoint . 'media/popular?' . http_build_query( $query )
			);


		/**
		 * Return response
		 */
		return static::_curl( $options );
	}


	/**
	 * Search media at Instagram
	 */
	public function searchMedia( $lat= '', $lng = '', $min_timestamp = '', $max_timestamp = '', $distance = '', $count = 25 )	{

		/**
		 * Throw exception if no valid access token
		 */
		if ( ! $this->access_token )
			throw new Exception( 'Invalid access token.' );


		/**
		 * Set request parameters
		 */
		$query = array(
				'access_token' => $this->access_token,
				'count' => (int) $count
			);


		/**
		 * Set lat lng
		 * Both values must be provided
		 */
		if ( $lat && $lng ) {
			$query['lat'] = (float) $lat;
			$query['lng'] = (float) $lng;
		}


		/**
		 * Set minimum UNIX timestamp for request
		 */
		if ( $min_timestamp )
			$query['min_timestamp'] = (int) $min_timestamp;


		/**
		 * Set maximum UNIX timestamp for request
		 */
		if ( $max_timestamp )
			$query['max_timestamp'] = (int) $max_timestamp;


		/**
		 * Set distance parameter (in meters)
		 */
		if ( $distance )
			$query['distance'] = (int) $distance;


		/**
		 * Set CURL request URL
		 */
		$options = array(
				'url' => $this->endpoint . 'media/search?' . http_build_query( $query )
			);


		/**
		 * Return response
		 */
		return static::_curl( $options );
	}

}