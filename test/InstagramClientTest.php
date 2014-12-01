<?php

/**
 * Unit test suite
 * @author: hello@jabran.me
 */

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
		$this->config = array(
			'client_id' => '',
			'client_secret' => '',
			'redirect_uri' => ''
			);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSimpleInitialize() {
		$this->client = new InstagramClient();
	}


	/**
	 * Destructor
	 */
	public function tearDown() {
		unset($this->client);
	}
}