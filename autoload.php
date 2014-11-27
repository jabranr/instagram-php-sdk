<?php

/**
 * Autoload file
 *
 * You will not need this if you are using Composer.
 * https://getcomposer.org
 *
 * PSR-4 standard: http://www.php-fig.org/psr/psr-4/
 */

spl_autoload_register(function( $class )	{

	$prefix = 'Instagram\\';

	$base_dir = defined('INSTAGRAM_SRC_DIR') ? INSTAGRAM_SRC_DIR : dirname(__FILE__) . '/src/Instagram/';

	$len = strlen($prefix);

	if ( strncmp($prefix, $class, $len) !== 0 ) {
		return;
	}

	$rel_class = substr($class, $len);

	$file = $base_dir . DIRECTORY_SEPARATOR . str_replace('\\', '/', $rel_class) . '.php';

	if ( file_exists($file) ) {
		require $file;
	}

});