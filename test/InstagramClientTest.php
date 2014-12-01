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
	 * @expectedException Exception
	 */
	public function testException() {
		$this->client = new InstagramClient();
	}


	/**
	 * Destructor
	 */
	public function tearDown() {
		unset($this->client);
	}
}