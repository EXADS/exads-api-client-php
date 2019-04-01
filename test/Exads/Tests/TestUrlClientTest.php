<?php

namespace Exads\Tests;

use Exads\TestUrlClient;

class TestUrlClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Exads\TestUrlClient
     * @test
     */
    public function test_get_returns_path_and_method()
    {
        $expectedReturn = array('method' => 'GET', 'path' => '/some/path');
        $client = new TestUrlClient('http://localhost');
        $this->assertSame($expectedReturn, $client->get('/some/path'));
    }

    /**
     * @covers \Exads\TestUrlClient
     * @test
     */
    public function test_delete_returns_path_and_method()
    {
        $expectedReturn = array('method' => 'DELETE', 'path' => '/some/path');
        $client = new TestUrlClient('http://localhost');
        $this->assertSame($expectedReturn, $client->delete('/some/path'));
    }

    /**
     * @covers \Exads\TestUrlClient
     * @test
     */
    public function test_post_returns_path_and_method()
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
    public function test_put_returns_path_and_method()
    {
        $expectedReturn = array('method' => 'PUT', 'path' => '/some/path');
        $client = new TestUrlClient('http://localhost');
        $this->assertSame(
            $expectedReturn,
            $client->put('/some/path', array())
        );
    }
}
