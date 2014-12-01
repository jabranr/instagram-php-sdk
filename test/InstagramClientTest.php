<?php

/**
 * Unit test suite
 * @author: hello@jabran.me
 */

namespace Instagram\Tests;
use PHPUnit_Framework_TestCase;
use Instagram\InstagramClient;

require('./autoload.php');

class InstagramClientTest extends PHPUnit_Framework_TestCase {

	/**
	 * Variables
	 */
	public $config, $client;


	/**
	 * Setup / Constructor
	 */
	public function setUp() {
		$this->client = null;
		$this->config = array();
	}

	/**
	 * Test exception if none argument is passed
	 * @expectedException Exception
	 */
	public function testInvalidArgumentException() {
		$this->client = new InstagramClient();
	}


	/**
	 * Test exception if arguments are empty or null
	 * @expectedException Exception
	 */
	public function testEmptyArgumentException() {
		$this->client = new InstagramClient( $this->config );
	}


	/**
	 * Test exception if one of the arguments is missing/invalid
	 * @expectedException Exception
	 */
	public function testAnyInvalidArgumentException() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret'
			);

		$this->client = new InstagramClient( $this->config );
	}


	/**
	 * Should set default 'likes' scope if none provided
	 */
	public function testDefaultScope() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );

		return $this->assertEquals($this->client->get_scope(), 'likes');
	}


	/**
	 * Test custom set scope
	 */
	public function testCustomScope() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		return $this->assertEquals($this->client->set_scope('likes+comments')->get_scope(), 'likes+comments');
	}


	/**
	 * Get default config arugments
	 */
	public function testConfigArgument() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->get_client_id(), 'aDummyClientId');
		$this->assertEquals($this->client->get_client_secret(), 'aDummyClientSecret');
		$this->assertEquals($this->client->get_redirect_uri(), 'aDummyRedirectURL');
	}


	/**
	 * Test default API uri
	 */
	public function testDefaultApiUri() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->get_api_uri(), 'https://api.instagram.com/');
	}


	/**
	 * Test custom API uri
	 */
	public function testCustomApiUri() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->set_api_uri('http://example.com/')->get_api_uri(), 'http://example.com/');
	}


	/**
	 * Test default oauth uri
	 */
	public function testDefaultOauthUri() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->get_oauth_uri(), $this->client->get_api_uri() . 'oauth/authorize/');
	}


	/**
	 * Test custom oauth uri
	 */
	public function testCustomOauthUri() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->set_oauth_uri('path/to/oauth/')->get_oauth_uri(), 'path/to/oauth/');
	}


	/**
	 * Test default access token uri
	 */
	public function testDefaultAccessTokenUri() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->get_access_token_uri(), $this->client->get_api_uri() . 'oauth/access_token/');
	}


	/**
	 * Test custom access token uri
	 */
	public function testCustomAccessTokenUri() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->set_access_token_uri('path/to/accessToken/')->get_access_token_uri(), 'path/to/accessToken/');
	}


	/**
	 * Test default grant type
	 */
	public function testDefaultGrantType() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->get_grant_type(), 'authorization_code');
	}


	/**
	 * Test custom grant type
	 */
	public function testCustomGrantType() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->set_grant_type('custom_authorization_code')->get_grant_type(), 'custom_authorization_code');
	}


	/**
	 * Test default response type
	 */
	public function testDefaultResponseType() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->get_response_type(), 'code');
	}


	/**
	 * Test custom response type
	 */
	public function testCustomResponseType() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->set_response_type('custom_code')->get_response_type(), 'custom_code');
	}


	/**
	 * Test default endpoint
	 */
	public function testDefaultEndpoint() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->get_endpoint(), $this->client->get_api_uri() . 'v1/');
	}


	/**
	 * Test custom endpoint
	 */
	public function testCustomEndpoint() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->set_endpoint('path/to/custom/endpoint')->get_endpoint(), 'path/to/custom/endpoint');
	}


	/**
	 * Test default data
	 */
	public function testDefaultData() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertNull($this->client->get_data());
	}


	/**
	 * Test custom data
	 */
	public function testAssignedData() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals($this->client->set_data(array('some' => 'data'))->get_data(), array('some' => 'data'));
	}


	/**
	 * Test oauth url
	 */
	public function testOauthUrl() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->assertEquals(
				$this->client->get_oauth_url(),
				$this->client->get_oauth_uri() . '?' .
				http_build_query( array(
					'client_id' => $this->client->get_client_id(),
					'redirect_uri' => $this->client->get_redirect_uri(),
					'response_type' => $this->client->get_response_type(),
					'scope' => $this->client->get_scope(),
					)
				)
			);
	}


	/**
	 * Test access token exception if no code provided
	 * @expectedException Exception
	 */
	public function testAccessTokenEmptyCodeException() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );

		return $this->client->get_access_token(true);
	}


	/**
	 * Test access token response if invalid/valid code is provided
	 * This collects the server response from Instagram API
	 * and sets to data property of client
	 */
	public function testAccessTokenWithInvalidCode() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->client->get_access_token(true, 'someRandomInvalidCode');
		$this->assertNotNull($this->client->get_data(), 'Failed to get response from Instagram API');

		$data = json_decode($this->client->get_data(), true);
		$this->assertArrayHasKey('error_message', $data, 'Error returned from Instagram API.');
		$this->assertArrayHasKey('error_type', $data);
		$this->assertEquals($data['error_type'], 'OAuthException');
		$this->assertEquals($data['code'], 400);
	}


	/**
	 * Test searchMedia method for exception with no lat,lng
	 * @expectedException Exception
	 */
	public function testSearchMediaLatLngException() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->client->searchMedia();
	}


	/**
	 * Test searchMedia method for exception on empty access token
	 * @expectedException Exception
	 */
	public function testSearchMediaEmptyAccessTokenException() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->client->searchMedia(30,70);
	}


	/**
	 * Test searchMedia results for invalid access token
	 */
	public function testSearchMediaInvalidAccessTokenServerResponse() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->client->set_access_token('someInvalidAccessToken');
		$this->client->searchMedia(30,70);

		$data = json_decode($this->client->get_data(), true);

		$this->assertNotNull($data);
		$this->assertArrayHasKey('meta', $data, 'Error returned from Instagram API.');
		$this->assertArrayHasKey('error_message', $data['meta']);
		$this->assertArrayHasKey('error_type', $data['meta']);
		$this->assertEquals($data['meta']['error_type'], 'OAuthAccessTokenException');
		$this->assertEquals($data['meta']['code'], 400);
	}


	/**
	 * Test popularMedia method for exception on empty access token
	 * @expectedException Exception
	 */
	public function testPopularMediaException() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->client->popularMedia();
	}


	/**
	 * Test popularMedia results for invalid access token
	 */
	public function testPopularMediaInvalidAccessTokenServerResponse() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->client->set_access_token('someInvalidAccessToken');
		$this->client->popularMedia();

		$data = json_decode($this->client->get_data(), true);

		$this->assertNotNull($data);
		$this->assertArrayHasKey('meta', $data, 'Error returned from Instagram API.');
		$this->assertArrayHasKey('error_message', $data['meta']);
		$this->assertArrayHasKey('error_type', $data['meta']);
		$this->assertEquals($data['meta']['error_type'], 'OAuthAccessTokenException');
		$this->assertEquals($data['meta']['code'], 400);
	}


	/**
	 * Test getMedia method for exception with no media ID
	 * @expectedException Exception
	 */
	public function testgetMediaMissingIDException() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->client->getMedia();
	}


	/**
	 * Test getMedia method for exception on empty access token
	 * @expectedException Exception
	 */
	public function testgetMediaEmptyAccessTokenException() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->client->getMedia(3);
	}


	/**
	 * Test getMedia results for invalid access token
	 */
	public function testgetMediaInvalidAccessTokenServerResponse() {
		$this->config = array(
				'client_id' => 'aDummyClientId',
				'client_secret' => 'aDummyClientSecret',
				'redirect_uri' => 'aDummyRedirectURL'
			);

		$this->client = new InstagramClient( $this->config );
		$this->client->set_access_token('someInvalidAccessToken');
		$this->client->getMedia(3);

		$data = json_decode($this->client->get_data(), true);

		$this->assertNotNull($data);
		$this->assertArrayHasKey('meta', $data, 'Error returned from Instagram API.');
		$this->assertArrayHasKey('error_message', $data['meta']);
		$this->assertArrayHasKey('error_type', $data['meta']);
		$this->assertEquals($data['meta']['error_type'], 'OAuthAccessTokenException');
		$this->assertEquals($data['meta']['code'], 400);
	}


	/**
	 * Destructor
	 */
	public function tearDown() {
		unset($this->config);
		unset($this->client);
	}

}