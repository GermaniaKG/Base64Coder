<?php
namespace Germania\Base64Coder\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Germania\Base64Coder\Base64Coder;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class PimpleServiceProvider implements ServiceProviderInterface
{
    /**
     * @var string
     */
    public $separator;

    /**
     * @var LoggerInterface
     */
    public $logger;


    /**
     * @param string $separator Separator sign, defaults to `::`
     * @param LoggerInterface|null $logger Optional: PSR3 Logger instance
     */
    public function __construct( $separator = '::', LoggerInterface $logger = null)
    {
        $this->separator = $separator;
        $this->logger    = $logger ?: new NullLogger;
    }

    /**
     * @implements ServiceProviderInterface
     */
    public function register(Container $dic)
    {


        /**
         * @return Callable
         */
        $dic['Cookie.Encryptor'] = $dic->protect(function($selector, $token) {
            $coder = new Base64Coder( $this->separator, $this->logger);
            return $coder->encode($selector, $token);
        });


        /**
         * @return Callable
         */
        $dic['Cookie.Decryptor'] = $dic->protect(function( $encrypted ) {
            $coder = new Base64Coder( $this->separator, $this->logger);
            return $coder->decode( $encrypted);
        });


    }
}

