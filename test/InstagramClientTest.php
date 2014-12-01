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
	 * @expectedException InvalidArgumentException
	 */
	public function testInvalidArgumentException() {
		$this->client = new InstagramClient();
	}


	/**
	 * Test exception if arguments are empty or null
	 * @expectedException InvalidArgumentException
	 */
	public function testEmptyArgumentException() {
		$this->client = new InstagramClient( $this->config );
	}


	/**
	 * Destructor
	 */
	public function tearDown() {
		unset($this->client);
	}
}