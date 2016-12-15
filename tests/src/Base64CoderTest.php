<?php
namespace tests;

use Germania\Base64Coder\Base64Coder;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Base64CoderTest extends \PHPUnit_Framework_TestCase
{

    public $logger;
    public $generator;


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

        $factory = new \RandomLib\Factory;
        $generator = $factory->getMediumStrengthGenerator();

        $max = 50;

        $data = array(
            array( "::", "foo", "bar")
        );

        $rndint = function() use ($generator){
            return $generator->generateInt(12, 64);
        };

        for ($i = 0; $i < $max; $i++) {
            $s = $generator->generateString( $rndint() );
            $t = $generator->generate($rndint() );

            $data[] = array('::', $s, $t);
        }

        for ($i = 0; $i < $max; $i++) {
            $s = $generator->generate( $rndint() );
            $t = $generator->generateString( $rndint() );

            $data[] = array('::', $s, $t);
        }

        for ($i = 0; $i < $max; $i++) {
            $s = $generator->generateString( $rndint() );
            $t = $generator->generateString( $rndint() );

            $data[] = array('::', $s, $t);
        }

        for ($i = 0; $i < $max; $i++) {
            $s = $generator->generate( $rndint() );
            $t = $generator->generate( $rndint() );

            $data[] = array('::', $s, $t);
        }

        for ($i = 0; $i < $max; $i++) {
            $s = random_bytes( $rndint() );
            $t = random_bytes( $rndint() );

            $data[] = array('::', $s, $t);
        }

        return $data;
    }
}
