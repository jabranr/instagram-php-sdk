<?php

/**
 * Unit test suite
 * @author: hello@jabran.me
 */

require('./autoload.php');

class InstagramClientCTest extends PHPUnit_Framework_TestCase {
	public $config, $client;

	public function setUp( $config = array() ) {
		$this->config = $config;

		$this->client = new InstagramClient( $this->config );
	}

	public function tearDown() {
		unset($this->client);
	}
}