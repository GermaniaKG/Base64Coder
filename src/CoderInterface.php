<?php
namespace Germania\Base64Coder;

/**
 * Defines methods for encoding and decoding selector and token pairs.
 */
interface CoderInterface
{
    /**
     * Encodes a persistent login selector and a token for using with cookie.
     *
     * @param  string $selector
     * @param  string $token
     * @return string Encoded string
     */
    public function encode( $selector, $token );

    /**
     * Decodes encoded cookie information to selector and token.
     *
     * @param  string $encoded Encoded string
     * @return object          StdClass object with 'selector' and 'token' member
     */
    public function decode( $encoded );

}
