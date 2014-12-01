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
	protected $_data;


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
	public function get_access_token( $fresh = false, $code = '' )	{
		if ( $fresh )
			return $this->_get_access_token( $code );
		return $this->access_token;
	}


	/**
	 * Set access token
	 */
	public function set_access_token( $token )	{
		$this->access_token = $token;
		return $this;
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
		$this->client_id = $client_id;
		return $this;
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
		$this->client_secret = $client_secret;
		return $this;
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
		$this->redirect_uri = $redirect_uri;
		return $this;
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
		$this->scope = $scope;
		return $this;
	}


	/**
	 * Get API URI
	 */
	public function get_api_uri()	{
		return $this->api_uri;
	}


	/**
	 * Set API URI
	 */
	public function set_api_uri( $api_uri )	{
		$this->api_uri = $api_uri;
		return $this;
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
		$this->oauth_uri = $oauth_uri;
		return $this;
	}


	/**
	 * Get access token URI
	 */
	public function get_access_token_uri()	{
		return $this->access_token_uri;
	}


	/**
	 * Set access token URI
	 */
	public function set_access_token_uri( $access_token_uri )	{
		$this->access_token_uri = $access_token_uri;
		return $this;
	}


	/**
	 * Get grant type
	 */
	public function get_grant_type()	{
		return $this->grant_type;
	}


	/**
	 * Set grant type
	 */
	public function set_grant_type( $grant_type )	{
		$this->grant_type = $grant_type;
		return $this;
	}


	/**
	 * Get response type
	 */
	public function get_response_type()	{
		return $this->response_type;
	}


	/**
	 * Set response type
	 */
	public function set_response_type( $response_type )	{
		$this->response_type = $response_type;
		return $this;
	}


	/**
	 * Get endpoint
	 */
	public function get_endpoint()	{
		return $this->endpoint;
	}


	/**
	 * Set endpoint
	 */
	public function set_endpoint( $endpoint )	{
		$this->endpoint = $endpoint;
		return $this;
	}


	/**
	 * Get data
	 */
	public function get_data()	{
		return $this->_data;
	}


	/**
	 * Set data
	 */
	public function set_data( $data )	{
		$this->_data = $data;
		return $this;
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
	private function _get_access_token( $code )	{

		if ( empty($code) )
			throw new Exception( 'Invalid response code for this request.' );

		$response = null;
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

		if ( $response = $this->_curl( $options ) ) {

			if ( $responseArray = json_decode( $response, true ) ) {

				if ( isset( $responseArray['access_token'] ) )
					$this->set_access_token( $responseArray['access_token'] );

			}
		}

		$this->set_data( $response );

		return $this;
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
		 * Set data to null
		 */
		$this->_data = null;


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
				'access_token' => ''
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

		$curl = curl_init();
		curl_setopt_array( $curl, $curl_options );

		if ( isset($options['post']) && $options['post'] === true ) {
			curl_setopt($curl, CURLOPT_POST, true);

			if ( isset($options['postfields']) && $options['postfields'] && is_array($options['postfields']) )
				curl_setopt($curl, CURLOPT_POSTFIELDS, $options['postfields']);
		}

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