# Germania KG · Base64Coder

**Converts a *selector* and *token* pair to base64 forth and back.**

[![Packagist](https://img.shields.io/packagist/v/germania-kg/base64-code.svg?style=flat)](https://packagist.org/packages/germania-kg/base64-code)
[![PHP version](https://img.shields.io/packagist/php-v/germania-kg/base64-code.svg)](https://packagist.org/packages/germania-kg/base64-code)
[![Tests](https://github.com/VENDOR/PACKAGE/actions/workflows/tests.yml/badge.svg)](https://github.com/VENDOR/PACKAGE/actions/workflows/tests.yml)


## Installation with Composer

```bash
$ composer require germania-kg/base64-code
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
use Germania\Base64Coder\EncoderCallable;
use Germania\Base64Coder\DecoderCallable;
use Germania\Base64Coder\Base64Coder;
use Psr\Log\LoggerInterface;

// have your Pimple DIC ready, and optionally a PSR3 Logger:
$sp = new PimpleServiceProvider;
$custom_separator = "::";
$sp = new PimpleServiceProvider($separator, $psr3_logger);

$sp->register( $dic );

// Grab your services;
// See also above examaples.
$base64coder = $dic[Base64Coder::class];

$encoder = $dic['Cookie.Encryptor']; // Deprecated
$encoder = $dic[EncoderCallable::class];
$encoded_string = $encoder("selector", "token");

$decoder = $dic['Cookie.Decryptor']; // Deprecated
$decoder = $dic[DecoderCallable::class];
$decoded_obj = $decoder( $encoded_string );

echo $decoded_obj->selector;
echo $decoded_obj->token;

```

## Issues

See [issues list.][i0]

[i0]: https://github.com/GermaniaKG/Base64Coder/issues

## Development

```bash
$ git clone https://github.com/GermaniaKG/Base64Coder.git
$ cd Base64Coder
$ composer install
```

## Unit tests

Either copy `phpunit.xml.dist` to `phpunit.xml` and adapt to your needs, or leave as is. Run [PhpUnit](https://phpunit.de/) test or composer scripts like this:

```bash
$ composer test
# or
$ vendor/bin/phpunit
```


