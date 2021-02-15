<?php
namespace tests;

use Germania\Base64Coder\Providers\PimpleServiceProvider;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Psr\Log\LoggerInterface;

class PimpleServiceProviderTest extends \PHPUnit\Framework\TestCase
{


    /**
     * @dataProvider provideCtorArguments
     */
    public function testRegisteringServiceProvider( $separator, $logger) : void
    {
        $dic = new Container;

        $sut = new PimpleServiceProvider;
        $sut->register( $dic );

        $this->assertInstanceOf( ServiceProviderInterface::class, $sut );

        $this->assertTrue( is_callable( $dic['Cookie.Encryptor']) );
        $this->assertTrue( is_callable( $dic['Cookie.Decryptor']) );

    }

    public function provideCtorArguments() : array
    {
        $logger = $this->prophesize( LoggerInterface::class );

        return [
            [ null, null ],
            [ null, $logger->reveal() ]
        ];
    }
}
