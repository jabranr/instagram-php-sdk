# Instagram PHP SDK [![Build Status](https://travis-ci.org/jabranr/instagram-php-sdk.svg)](https://travis-ci.org/jabranr/instagram-php-sdk) [![Analytics](https://ga-beacon.appspot.com/UA-50688851-1/instagram-php-sdk)](https://github.com/igrigorik/ga-beacon)

PHP client for Instagram API

> **Disclaimer:** Although this project shares same name with famous social network but is NOT an official version of PHP [SDKs for Instagram](http://github.com/Instagram). The package is provided as it is with no guarantee or promises so please use at your own risk. [Instagram](http://instagram.com) is product of Instagram/Facebook.


## Install & Usage

+ Download the [latest release](https://github.com/jabranr/instagram-php-sdk/releases/) or install using [Composer](http://getcomposer.org)
+ Register client at [http://instagram.com/developer/clients/register/](http://instagram.com/developer/clients/register/) and get `client_id`, `client_secret` and `redirect_uri`.
+ Here is a basic use example:

```php
require('path/to/autoload.php');

use Instagram\InstagramClient;

$config = array(
	'client_id' => 'CLIENT_ID',
	'client_secret' => 'CLIENT_SECRET',
	'redirect_uri' => 'http://example.com'
);

try {
	$ig = new InstagramClient( $config );
} catch (Exception $e) {
	echo $e->getMessage();
}

if ( isset($ig) && $ig ) {


	/**
	 * Get a new access token with OAuth
	 */

	if ( isset($_GET['code']) ) {
		$ig->get_access_token( $fresh = true, $_GET['code'] );

		print_r( $ig->get_data() );

		/**
		 * Make API requests. See various methods underneath.
		 */
	}

	/**
	 * Or display a login with Instagram link for redirect user for OAuth
	 */
	else {
		echo '<a href="' . $ig->get_oauth_url() . '">Login with Insgatram</a>';
	}


	/**
	 * Or set an existing access token
	 */

	$ig->set_access_token( 'A_valid_access_token_obtained_previously' );

	print_r( $ig->get_data() );

	/**
	 * Make API requests. See various methods underneath.
	 */

}
```


## Documentation

Use following methods to make requests to Instagram API.


#### Get Popular Media

```php
try	{

	$media = $ig->popularMedia( (int) $count = 25 );
	$media = json_decode( $media );
	print_r( $media );

} catch(Exception $e) {
	echo $e->getMessage();
}
```


#### Search Media

```php

/**
 * Atleast lat and lng are required to make requests to this endpoint
 */

try {
	$media = $ig->searchMedia(
					(float) $lat,
					(float) $lng,
					(UNIX_TIMESTAMP) $min_timestamp,
					(UNIX_TIMESTAMP) $max_timestamp,
					(int) $distance,
					(int) $count = 25 );

	$media = json_decode( $media );
	print_r( $media );
} catch(Exception $e) {
	echo $e->getMessage();
}

```


#### Get Media using an ID

```php
try {
	$media = $ig->getMedia( (int) $media_id );
	$media = json_decode( $media );
	print_r( $media );
} catch(Exception $e) {
	echo $e->getMessage();
}
```

# License

MIT License - &copy; [Jabran Rafique](http://jabran.me) 2014
