# Instagram PHP SDK (Unofficial)

PHP client for Instagram API

> **Disclaimer:** Although this project shares same name with famous social network but is NOT an official version of PHP [SDKs for Instagram](http://github.com/Instagram). The package is provided as it is with no guarantee or promises so please use at your own risk. [Instagram](http://instagram.com) is product of Instagram/Facebook.


# Install & Use

+ Download the [latest release](https://github.com/jabranr/instagram-php-sdk/releases/) or install using [Composer](http://getcomposer.org)
+ Register client at [http://instagram.com/developer/clients/register/](http://instagram.com/developer/clients/register/) and get `client_id`, `client_secret` and `redirect_uri`.
+ Here is a basic use example:

```php
require(./autload.php);

use Instagram\InstagramClient;

$config = array(
	'client_id' => 'A_B_C',
	'client_secret' => 'X_Y_Z',
	'redirect_uri' => 'http://example.com'
);

try {
	$ig = new InstagramClient( $config );
} catch (Exception $e) {
	echo $e->getMessage();
}

if ( isset($ig) && $ig ) {

	/**
	 * See documentation underneath for
	 * API request methods to use here
	 */
}
```

# Documentation

#### Get Popular Media

#### Search Media

#### Get Media using `media_id`