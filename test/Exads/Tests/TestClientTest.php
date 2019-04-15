<?php

namespace Exads\Tests;

use Exads\TestClient;
use Exception;

class TestClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Exads\TestClient
     * @test
     * @expectedException Exception
     */
    public function test_get_method_not_available()
    {
        $client = new TestClient('http://localhost');
        $client->get('does_not_exist');
    }

    /**
     * @covers \Exads\TestClient
     * @test
     * @expectedException Exception
     */
    public function test_delete_method_not_available()
    {
        $client = new TestClient('http://localhost');
        $client->delete('does_not_exist');
    }

    /**
     * @covers \Exads\TestClient
     * @test
     * @expectedException Exception
     */
    public function test_post_method_not_available()
    {
        $client = new TestClient('http://localhost');
        $client->post('does_not_exist', 'POST method not available');
    }

    /**
     * @covers \Exads\TestClient
     * @test
     * @expectedException Exception
     */
    public function test_put_method_not_available()
    {
        $client = new TestClient('http://localhost');
        $client->put('does_not_exist', 'PUT method not available');
    }
}
