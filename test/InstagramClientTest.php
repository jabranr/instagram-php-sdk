<?php

/**
 * Unit test suite
 * @author: hello@jabran.me
 */

namespace Instagram\Tests;

require('./autoload.php');

use PHPUnit_Framework_TestCase;
use Instagram\InstagramClient;

class InstagramClientTest extends PHPUnit_Framework_TestCase {

	/**
	 * Variables
	 */
	public $config, $client;


	/**
	 * Setup / Constructor
	 */
	public function setUp() {
		$this->config = array(
			'client_id' => '',
			'client_secret' => '',
			'redirect_uri' => ''
			);
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
		$this->config['client_id'] = 'aDummyClientId';
		$this->config['client_secret'] = 'aDummyClientSecret';

		$this->client = new InstagramClient( $this->config );
	}


	/**
	 * Should set default 'likes' scope if none provided
	 */
	public function testDefaultScope() {
		$this->config['client_id'] = 'aDummyClientId';
		$this->config['client_secret'] = 'aDummyClientSecret';
		$this->config['redirect_uri'] = 'aDummyRedirectURL';

		$this->client = new InstagramClient( $this->config );

		return $this->assertEquals($this->client->get_scope(), 'likes');
	}


	/**
	 * Test custom set scope
	 */
	public function testCustomScope() {
		$this->config['client_id'] = 'aDummyClientId';
		$this->config['client_secret'] = 'aDummyClientSecret';
		$this->config['redirect_uri'] = 'aDummyRedirectURL';

		$this->client = new InstagramClient( $this->config );

		$this->client->set_scope('likes+comments');

		return $this->assertEquals($this->client->get_scope(), 'likes+comments');
	}


	/**
	 * Get default config arugments
	 */
	public function testConfigArgument() {
		$this->config['client_id'] = 'aDummyClientId';
		$this->config['client_secret'] = 'aDummyClientSecret';
		$this->config['redirect_uri'] = 'aDummyRedirectURL';

		$this->client = new InstagramClient( $this->config );

		$this->assertEquals($this->client->get_client_id(), 'aDummyClientId');
		$this->assertEquals($this->client->get_client_secret(), 'aDummyClientSecret');
		$this->assertEquals($this->client->get_redirect_uri(), 'aDummyRedirectURL');
	}


	/**
	 * Destructor
	 */
	public function tearDown() {
		unset($this->client);
	}
}