<?php
namespace Germania\Base64Coder;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerAwareInterface;

abstract class CallableCoderAbstract implements LoggerAwareInterface {

    use LoggerAwareTrait;

    /**
     * @var CoderInterface
     */
    public $coder;

    public function __construct( CoderInterface $coder, LoggerInterface $logger )
    {
        $this->coder = $coder;
        $this->setLogger($logger);
    }

    public function setCoder( CoderInterface $coder )
    {
        $this->coder = $coder;
    }

}
