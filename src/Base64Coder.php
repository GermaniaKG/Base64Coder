<?php
namespace Germania\Base64Coder;

use Germania\Base64Coder\Exceptions\DecodingException;
use Germania\Base64Coder\Exceptions\EncodingException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;


class Base64Coder implements CoderInterface
{
    /**
     * @var string
     */
    public $separator = "::";

    /**
     * @var LoggerInterface
     */
    public $logger;


    /**
     * @param string               $separator Separator sign, defaults to `::`
     * @param LoggerInterface|null $logger    Optional: PSR-3 Logger
     */
    public function __construct( $separator = null, LoggerInterface $logger = null )
    {
        $this->separator = $separator ?: $this->separator;
        $this->logger    = $logger ?: new NullLogger;
    }


    /**
     * Base64-encodes a persistent login selector and a token for using with cookie.
     *
     * @param  string $selector
     * @param  string $token
     * @return string Encoded string
     * @throws EncodingException
     */
    public function encode( $selector, $token )
    {
        $result = implode( $this->separator, [
            base64_encode($selector),
            base64_encode($token)
        ]);

        if ($result === false):
            $e_msg = "Could not base64_encode selector and token";
            $this->logger->error( $e_msg );
            throw new EncodingException( $e_msg );
        endif;

        return $result;
    }


    /**
     * Decodes base64-encoded cookie information to selector and token.
     *
     * @param  string $base64_encoded Encoded string
     * @return object                 StdClass object with 'selector' and 'token' member
     *
     * @throws DecodingException
     */
    public function decode( $base64_encoded ) {

        // ----------------------------------------------
        // 1. This will contain parsed data
        // ----------------------------------------------
        $result = new \StdClass;


        // ----------------------------------------------
        // 2. Parse out Persistent Login Selector
        //    (i.e. all from beginning to first occurrence of separator)
        // ----------------------------------------------

        $base64_encoded_selector = mb_strstr($base64_encoded, $this->separator, "before_needle");
        $result->selector = base64_decode( $base64_encoded_selector, "strict" );
        if ($result->selector === false) :
            $e_msg = "Could not find separator in base64-encoded string";
            $this->logger->warning( $e_msg );
            throw new DecodingException( $e_msg );
        endif;


        // ----------------------------------------------
        // 3. Parse out Persistent Login Token
        //    (i.e. everything after first occurrence of separator)
        // ----------------------------------------------
        $token_incl_sep = mb_strstr($base64_encoded, $this->separator, false);
        $separator_len  = mb_strlen( $this->separator );

        $base64_encoded_token = mb_substr($token_incl_sep, $separator_len);
        $result->token  = base64_decode( $base64_encoded_token, "strict" );
        if ($result->token === false) :
            $e_msg = "Could not find token in base64-encoded string";
            $this->logger->warning( $e_msg );
            throw new DecodingException( $e_msg );
        endif;

        $this->logger->debug("Decoded data", [
            'selector'     => $result->selector,
            'token_length' => mb_strlen( $result->token )
        ]);

        // ----------------------------------------------
        // Return parsed result
        // ----------------------------------------------
        return $result;

    }
}
