<?php
namespace tests;

use Germania\Base64Coder\Base64Coder;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use RandomLib\Factory as RandomLibFactory;

class Base64CoderTest extends \PHPUnit_Framework_TestCase
{

    public $logger;
    public $generator;

    public $max_runs = 50;

    public function setUp()
    {
        $this->logger = new NullLogger;

    }


    /**
     * @dataProvider provideWorkData
     */
    public function testDecoding( $separator, $selector, $token)
    {
        $sut = new Base64Coder( $separator, $this->logger);

        // forth
        $encoded = $sut->encode($selector, $token);

        // and back
        $decoded = $sut->decode( $encoded );

        $this->assertInternalType("object", $decoded);

        // Decoded values must match the input values!
        $this->assertSame($selector, $decoded->selector);
        $this->assertSame($token,    $decoded->token);
    }


    public function provideWorkData()
    {

        $factory = new RandomLibFactory;
        $generator = $factory->getMediumStrengthGenerator();


        $data = array(
            array( "::", "foo", "bar")
        );

        $rndint = function() use ($generator){
            return $generator->generateInt(12, 128);
        };

        for ($i = 0; $i < $this->max_runs; $i++) {
            $s = $generator->generateString( $rndint() );
            $t = $generator->generate($rndint() );
            $sep = $generator->generateString( $rndint() );
            $data[] = array( $sep, $s, $t);
        }

        for ($i = 0; $i < $this->max_runs; $i++) {
            $s = $generator->generate( $rndint() );
            $t = $generator->generateString( $rndint() );
            $sep = $generator->generateString( $rndint() );
            $data[] = array( $sep, $s, $t);
        }

        for ($i = 0; $i < $this->max_runs; $i++) {
            $s = $generator->generateString( $rndint() );
            $t = $generator->generateString( $rndint() );
            $sep = $generator->generateString( $rndint() );
            $data[] = array( $sep, $s, $t);
        }

        for ($i = 0; $i < $this->max_runs; $i++) {
            $s = $generator->generate( $rndint() );
            $t = $generator->generate( $rndint() );
            $sep = $generator->generateString( $rndint() );
            $data[] = array( $sep, $s, $t);
        }

        for ($i = 0; $i < $this->max_runs; $i++) {
            $s = random_bytes( $rndint() );
            $t = random_bytes( $rndint() );
            $sep = $generator->generateString( $rndint() );
            $data[] = array( $sep, $s, $t);
        }

        return $data;
    }
}
