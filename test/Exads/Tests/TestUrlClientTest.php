<?php

namespace Exads\Tests;

use Exads\TestUrlClient;

class TestUrlClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Exads\TestUrlClient
     * @test
     */
    public function testGetReturnsPathAndMethod()
    {
        $expectedReturn = array('method' => 'GET', 'path' => '/some/path');
        $client = new TestUrlClient('http://localhost');
        $this->assertSame($expectedReturn, $client->get('/some/path'));
    }

    /**
     * @covers \Exads\TestUrlClient
     * @test
     */
    public function testDeleteReturnsPathAndMethod()
    {
        $expectedReturn = array('method' => 'DELETE', 'path' => '/some/path');
        $client = new TestUrlClient('http://localhost');
        $this->assertSame($expectedReturn, $client->delete('/some/path'));
    }

    /**
     * @covers \Exads\TestUrlClient
     * @test
     */
    public function testPostReturnsPathAndMethod()
    {
        $expectedReturn = array('method' => 'POST', 'path' => '/some/path');
        $client = new TestUrlClient('http://localhost');
        $this->assertSame(
            $expectedReturn,
            $client->post('/some/path', array())
        );
    }

    /**
     * @covers \Exads\TestUrlClient
     * @test
     */
    public function testPutReturnsPathAndMethod()
    {
        $expectedReturn = array('method' => 'PUT', 'path' => '/some/path');
        $client = new TestUrlClient('http://localhost');
        $this->assertSame(
            $expectedReturn,
            $client->put('/some/path', array())
        );
    }
}
