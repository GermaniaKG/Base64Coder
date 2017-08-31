# Germania KG · Base64Coder

**Converts a *selector* and *token* pair to base64 forth and back. It is tested with Anthony Ferrara's [ircmaxell/RandomLib](https://github.com/ircmaxell/RandomLib) and Paragonie's [paragonie/random_compat](https://github.com/paragonie/random_compat)**

[![Build Status](https://travis-ci.org/GermaniaKG/Base64Coder.svg?branch=master)](https://travis-ci.org/GermaniaKG/Base64Coder)
[![Code Coverage](https://scrutinizer-ci.com/g/GermaniaKG/Base64Coder/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Base64Coder/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GermaniaKG/Base64Coder/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Base64Coder/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/GermaniaKG/Base64Coder/badges/build.png?b=master)](https://scrutinizer-ci.com/g/GermaniaKG/Base64Coder/build-status/master)

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

## Pimple Service Provider

```php
<?php
use Germania\Base64Coder\Providers\PimpleServiceProvider;
use Psr\Log\LoggerInterface;

// have your Pimple DIC ready, and optionally a PSR3 Logger:
$sp = new PimpleServiceProvider;
$custom_separator = "::";
$sp = new PimpleServiceProvider($separator, $psr3_logger);

$sp->register( $dic );

// Grab your services;
// See also above examaples.
$encoder = $dic['Cookie.Encryptor'];
$encoded = $encoder("selector", "token");

$decoder = $dic['Cookie.Decryptor'];
$decoded = $decoder( $encoded );
echo $decoded->selector;
echo $decoded->token;

```

## Issues

See [issues list.][i0]

[i0]: https://github.com/GermaniaKG/Base64Coder/issues 

## Development

```bash
$ git clone git@github.com:GermaniaKG/Base64Coder.git base64-coder
$ cd base64-coder
$ composer install
```

## Unit tests

Either copy `phpunit.xml.dist` to `phpunit.xml` and adapt to your needs, or leave as is. 
Run [PhpUnit](https://phpunit.de/) like this:

```bash
$ vendor/bin/phpunit
```
