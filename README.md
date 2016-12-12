#Germania\Base64Coder

This class converts a *selector* and *token* pair to base64 forth and back.

##Installation

```bash
composer require germania-kg/base64-coder
```


##Usage


###Instantiation
```php
<?php
use Germania\Base64Coder\Base64Coder;
use Germania\Base64Coder\Exceptions\EncodingException;
use Germania\Base64Coder\Exceptions\DecodingException;

// Optional:
$logger    = new Monolog;
$separator = "::" // Default;

// Setup
$coder = new Base64Coder( $separator, $logger );
$coder = new Base64Coder( $separator );
$coder = new Base64Coder;
```


###Encoding selector and token
```php
<?php
$selector = "user_john";
$token    = "somerandomvalue";

try {
	$encoded = $coder->encode( $selector, $token);
	// Result is something like
	// "RGllcyBpc3ftvZ::GllcmVuZGVyIFN0cmluZw=="
} 
catch (EncodingException $e) {
	// PHP's base64_encode had returned FALSE
}
```

###Decoding encoded selector and token pair

```php
<?php
$encoded_value = 'RGllcyBpc3ftvZ::GllcmVuZGVyIFN0cmluZw==';

try {
	$decoded = $cookie_coder->decode( $encoded_value );

	// Result object:
	echo $decoded->selector; // "user_john"
	echo $decoded->token;    // "somerandomvalue"
	
catch (DecodingException $e) {
	// PHP's base64_decode had returned FALSE
}

```






##Development and Testing

Develop using `develop` branch, using [Git Flow](https://github.com/nvie/gitflow).   
**Currently, no tests are specified.**

```bash
$ git clone git@github.com:GermaniaKG/Base64Coder.git base64-coder
$ cd base64-coder
$ cp phpunit.xml.dist phpunit.xml
$ phpunit
```
