<?php

namespace Exads\Tests;

use Exads\Client;
use Exads\ClientInterface;
use InvalidArgumentException;

class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Exads\Client
     * @test
     */
    public function shouldInstanciateClientClass()
    {
        $client = new Client('http://localhost');
        $this->assertInstanceOf(ClientInterface::class, $client);
    }

    /**
     * @covers \Exads\Client
     * @test
     * @expectedException InvalidArgumentException
     */
    public function shouldNotGetApiInstance()
    {
        $client = new Client('http://localhost');
        $client->api('do_not_exist');
    }

    /**
     * @covers \Exads\Client
     * @test
     */
    public function shouldReturnAPIUrl()
    {
        $client = new Client('http://localhost');
        $this->assertSame('http://localhost', $client->getUrl());
    }

    /**
     * @covers \Exads\Client
     * @test
     */
    public function shouldFindCorrectPort()
    {
        $client = new Client('http://localhost');
        $this->assertSame(80, $client->getPort());

        $client = new Client('https://localhost');
        $this->assertSame(443, $client->getPort());
    }

    /**
     * @covers \Exads\Client
     * @test
     */
    public function shouldUpdatePort()
    {
        $client = new Client('http://localhost');
        $this->assertSame($client, $client->setPort(28080));
        $this->assertSame(28080, $client->getPort());
    }

    /**
     * @covers \Exads\Client
     * @test
     */
    public function responseShouldBe0ByDefault()
    {
        $client = new Client('http://localhost');
        $this->assertEquals(0, $client->getResponseCode());
    }

    /**
     * @covers \Exads\Client
     * @test
     */
    public function shouldDecodeValidJson()
    {
        // Test values
        $inputJson = '{"token":"34fb12b579a9e6bc7a28238db3ff79aed04827ab","type":"Bearer","expires_in":3600}';
        $expectedData = array(
            'token' => '34fb12b579a9e6bc7a28238db3ff79aed04827ab',
            'type' => 'Bearer',
            'expires_in' => 3600,
        );
        $client = new Client('http://localhost');
        $this->assertSame($expectedData, $client->decode($inputJson));
    }

    /**
     * @covers \Exads\Client
     * @test
     */
    public function testEmptyJsonDecode()
    {
        $invalidJson = '';
        $expectedError = '';
        $client = new Client('http://localhost');

        $this->assertSame($expectedError, $client->decode($invalidJson));
    }

    /**
     * @covers \Exads\Client
     * @test
     */
    public function testMalformedJsonShouldReturnError()
    {
        $invalidJson = '{"token":"34fb12b579a9e6bc7a28238db3ff79aed04827ab","type":"Bearer","expires_in":3600';
        $expectedError = 'Syntax error';
        $client = new Client('http://localhost');

        $this->assertSame($expectedError, $client->decode($invalidJson));

        $invalidJson = '{"token';
        $expectedError = 'Control character error, possibly incorrectly encoded';
        $this->assertSame($expectedError, $client->decode($invalidJson));
    }

    /**
     * @covers \Exads\Client
     * @test
     * @dataProvider getApiClassesProvider
     */
    public function shouldGetApiInstance($apiName, $class)
    {
        $client = new Client('http://localhost');
        $this->assertInstanceOf($class, $client->api($apiName));
    }

    public function getApiClassesProvider()
    {
        return array(
            array('campaigns', 'Exads\Api\Campaign'),
            array('login', 'Exads\Api\Login'),
            array('collections', 'Exads\Api\Collection'),
            array('payments_advertiser', 'Exads\Api\PaymentAdvertiser'),
            array('payments_publisher', 'Exads\Api\PaymentPublisher'),
            array('sites', 'Exads\Api\Site'),
            array('statistics_advertiser', 'Exads\Api\StatisticsAdvertiser'),
            array('statistics_publisher', 'Exads\Api\StatisticsPublisher'),
            array('user', 'Exads\Api\User'),
            array('zones', 'Exads\Api\Zone'),
        );
    }
}
