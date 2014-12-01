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

use Exception;

class InstagramClientBase	{


	/**
	 * Setup class variables
	 */
	public $_options;
	protected $_credentials;


	/**
	 * @override: Default construct method
	 */
	public function __construct( $config )	{

		/**
		 * Register default shutdown method
		 */
		register_shutdown_function( array($this, '__destruct') );

		/**
		 * Initialize
		 */
		return $this->_init( $config );
	}


	/**
	 * @override: Default magic __get method
	 */
	public function __get( $option )	{

		return $this->_options[$option];

	}

	/**
	 * @override: Default magic __set method
	 */
	public function __set( $option, $value )	{

		if ( array_key_exists( $option, $this->_options ) )	{
			$this->_options[$option] = $value;
		}

	}


	/**
	 * Get access token
	 */
	public function get_access_token()	{
		return $this->access_token;
	}


	/**
	 * Set access token
	 */
	public function set_access_token( $token )	{
		return $this->access_token = $token;
	}


	/**
	 * Get client_id
	 */
	public function get_client_id()	{
		return $this->client_id;
	}


	/**
	 * Set client_id
	 */
	public function set_client_id( $client_id )	{
		return $this->client_id = $client_id;
	}


	/**
	 * Get client_secret
	 */
	public function get_client_secret()	{
		return $this->client_secret;
	}


	/**
	 * Set client_secret
	 */
	public function set_client_secret( $client_secret )	{
		return $this->client_secret = $client_secret;
	}


	/**
	 * Get redirect uri
	 */
	public function get_redirect_uri()	{
		return $this->redirect_uri;
	}


	/**
	 * Set redirect uri
	 */
	public function set_redirect_uri( $redirect_uri )	{
		return $this->redirect_uri = $redirect_uri;
	}


	/**
	 * Get scope/permissions
	 */
	public function get_scope()	{
		return $this->scope;
	}


	/**
	 * Set scope/permissions
	 * Scope must be in format of "likes+comments"
	 */
	public function set_scope( $scope )	{
		return $this->scope = $scope;
	}


	/**
	 * Get OAuth URI
	 */
	public function get_oauth_uri()	{
		return $this->oauth_uri;
	}


	/**
	 * Set OAuth URI
	 */
	public function set_oauth_uri( $oauth_uri )	{
		return $this->oauth_uri = $oauth_uri;
	}


	/**
	 * Get OAuth URL
	 */
	public function get_oauth_url()	{
		return $this->_get_oauth_request_uri();
	}


	/**
	 * Get an access token for API requests
	 */
	public function access_token( $code )	{

		if ( empty($code) )
			throw new Exception( 'Invalid response code for this request.' );

		$options = array(
				'post' => true,
				'url' => $this->access_token_uri,
				'postfields' => array(
						'client_id' => $this->client_id,
						'client_secret' => $this->client_secret,
						'grant_type' => $this->grant_type,
						'redirect_uri' => $this->redirect_uri,
						'code' => $code
					)
			);

		$response = $this->_curl( $options );

		if ( $response && isset($response['error_message']) )
			throw new Exception( json_encode($response) );

		if ( $response && isset($response['access_token']) )	{
			$this->data = $response;
			$this->access_token = $response['access_token'];
		}

		return $this;
	}


	/**
	 * Get search results for media
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
		return $this->_curl( $options );
	}


	/**
	 * Get media by ID
	 */
	public function searchById( $media_id = 0 )	{

		$url = $this->__get('endpoint') . 'media/';
		$url .= $media_id;
		$url .= '?access_token=' . $this->__get('access_token');

		return $this->_curl( $url );
	}


	/**
	 * Get media by popularity
	 */
	public function searchByPopularity()	{

		$url = $this->__get('endpoint') . 'media/popular';
		$url .= '?access_token=' . $this->__get('access_token');

		return $this->_curl( $url );
	}


	/**
	 * Get recently tagged media
	 */
	public function searchByTag( $tag = '' )	{
		if ( empty($tag) === false )	{
			$tag = htmlentities($tag);
			$url = $this->__get('endpoint') . 'tags/' . $tag . '/media/recent';
			$url .= '?access_token=' . $this->__get('access_token');

			return $this->_curl( $url );
		}
		return false;
	}


	/**
	 * Get results by tag search
	 */
	public function searchByTagName( $tag = '' )	{
		if ( empty($tag) === false )	{
			$tag = htmlentities($tag);
			$url = $this->__get('endpoint') . 'tags/search';
			$url .= '?q=' . $tag . '&access_token=' . $this->__get('access_token');

			return $url;
		}
		return false;
	}


	/**
	 * Setup and initialize request
	 */
	protected function _init( $config )	{

		/**
		 * Throw exception if incomplete configuration
		 */
		if ( !isset($config['client_id']) || ( isset($config['client_id']) && empty($config['client_id']) ) )
			throw new Exception( 'Client ID is missing.' );

		elseif ( !isset($config['client_secret']) || ( isset($config['client_secret']) && empty($config['client_secret']) ) )
			throw new Exception( 'Client secret is missing.' );

		elseif ( !isset($config['redirect_uri']) || ( isset($config['redirect_uri']) && empty($config['redirect_uri']) ) )
			throw new Exception( 'Redirect URL is missing.' );


		/**
		 * Setup default scope
		 */
		if ( !isset($config['scope']) || ( isset($config['scope']) && empty($config['scope']) ) )
			$config['scope'] = 'likes';


		/**
		 * Setup API access points
		 */
		$this->_credentials = array(
				'redirect_uri' => $config['redirect_uri'],
				'api_uri' => 'https://api.instagram.com/',
				'endpoint' => 'v1/',
				'oauth_uri' => 'oauth/authorize/',
				'access_token_uri' => 'oauth/access_token/',
				'grant_type' => 'authorization_code',
				'response_type' => 'code',
				'access_token' => '',
				'data' => array()
			);


		/**
		 * Merge API access points and configurations
		 */
		$this->_options = array_merge($config, $this->_credentials);


		/**
		 * Prepare API acccess points
		 */
		$this->endpoint = $this->api_uri . $this->endpoint;
		$this->oauth_uri = $this->api_uri . $this->oauth_uri;
		$this->access_token_uri = $this->api_uri . $this->access_token_uri;

		return $this;
	}


	/**
	 * Setup OAuth URL for access token request
	 */
	protected function _get_oauth_request_uri() {
		$oauth_uri = array(
				'client_id' => $this->client_id,
				'redirect_uri' => $this->redirect_uri,
				'response_type' => $this->response_type,
				'scope' => $this->scope
			);

		return $this->oauth_uri . '?' . http_build_query($oauth_uri);
	}


	/**
	 * Process CURL requests
	 */
	protected static function _curl( $options = array() )	{

		if ( !isset($options['url']) || ( isset($options['url']) && empty($options['url']) ) )
			return false;

		$curl_options = array (
				CURLOPT_URL => $options['url'],
				CURLOPT_TIMEOUT => 30,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_USERAGENT => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
			);

		if ( isset($options['post']) && $options['post'] === true ) {
			$curl_options['CURLOPT_POST'] = true;

			if ( isset($options['postfields']) && $options['postfields'] && is_array($options['postfields']) )
				$curl_options['CURLOPT_POSTFIELDS'] = $options['postfields'];
		}

		$curl = curl_init();
		curl_setopt_array( $curl, $curl_options );
		$output = curl_exec( $curl );

		curl_close($curl);

		if ( $output )
			return $output;

		return false;
	}


	/**
	 * @override: Default __destruct method
	 */
	public function __destruct()	{
		return true;
	}

}