# Germania\Base64Coder

[![Build Status](https://travis-ci.org/GermaniaKG/Base64Coder.svg?branch=master)](https://travis-ci.org/GermaniaKG/Base64Coder)
[![Code Coverage](https://scrutinizer-ci.com/g/GermaniaKG/Base64Coder/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Base64Coder/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GermaniaKG/Base64Coder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Base64Coder/?branch=master)

This class converts a *selector* and *token* pair to base64 forth and back. It is tested with these common random libraries:

- Anthony Ferrara's [ircmaxell/RandomLib](https://github.com/ircmaxell/RandomLib)
- Paragonie's [paragonie/random_compat](https://github.com/paragonie/random_compat)

## Installation

```bash
composer require germania-kg/base64-coder
```


## Usage


### Instantiation
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


### Encoding selector and token
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

### Decoding encoded selector and token pair

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

## Exceptions

```php
<?php
use Germania\Base64Coder\Exceptions\CoderExceptionInterface;

class EncodingException implements CoderExceptionInterface {}
class DecodingException implements CoderExceptionInterface {}
```



## Development and Testing

Develop using `develop` branch, using [Git Flow](https://github.com/nvie/gitflow).   

See class `tests\Base64CoderTest` for random generated selectors, tokens, and separators.

```bash
$ git clone git@github.com:GermaniaKG/Base64Coder.git base64-coder
$ cd base64-coder
$ cp phpunit.xml.dist phpunit.xml
$ phpunit
```
