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
    public function should_instanciate_client_class()
    {
        $client = new Client('http://localhost');
        $this->assertInstanceOf(ClientInterface::class, $client);
    }

    /**
     * @covers \Exads\Client
     * @test
     * @expectedException InvalidArgumentException
     */
    public function should_not_get_api_instance()
    {
        $client = new Client('http://localhost');
        $client->api('do_not_exist');
    }

    /**
     * @covers \Exads\Client
     * @test
     */
    public function should_return_api_url()
    {
        $client = new Client('http://localhost');
        $this->assertSame('http://localhost', $client->getUrl());
    }

    /**
     * @covers \Exads\Client
     * @test
     */
    public function should_find_correct_port()
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
    public function should_update_port()
    {
        $client = new Client('http://localhost');
        $this->assertSame($client, $client->setPort(28080));
        $this->assertSame(28080, $client->getPort());
    }

    /**
     * @covers \Exads\Client
     * @test
     */
    public function response_should_be_0_by_default()
    {
        $client = new Client('http://localhost');
        $this->assertEquals(0, $client->getResponseCode());
    }

    /**
     * @covers \Exads\Client
     * @test
     */
    public function should_decode_valid_json()
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
    public function test_empty_json_decode()
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
    public function test_malformed_json_should_return_error()
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
