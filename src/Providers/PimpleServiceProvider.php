<?php
namespace Germania\Base64Coder\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

use Germania\Base64Coder\Base64Coder;
use Germania\Base64Coder\EncoderCallable;
use Germania\Base64Coder\DecoderCallable;

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

    public function register(Container $dic)
    {


        /**
         * @return Callable
         */
        $dic[Base64Coder::class] = function($dic) {
            return new Base64Coder( $this->separator, $this->logger);
        };



        /**
         * @return Callable
         */
        $dic[EncoderCallable::class] = function($dic) {
            $coder = $dic[Base64Coder::class];
            return new EncoderCallable($coder, $this->logger);
        };

        /**
         * @return Callable
         */
        $dic['Cookie.Encryptor'] = function($dic) {
            return $dic[EncoderCallable::class];
        };



        /**
         * @return Callable
         */
        $dic[DecoderCallable::class] = function($dic) {
            $coder = $dic[Base64Coder::class];
            return new DecoderCallable($coder, $this->logger);
        };


        /**
         * @return Callable
         */
        $dic['Cookie.Decryptor'] = function($dic) {
            return $dic[DecoderCallable::class];
        };



    }
}

