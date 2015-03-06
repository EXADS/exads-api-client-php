<?php

namespace Exads\Tests;

use Exads\TestClient;

class TestClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Exads\TestClient
     * @test
     * @expectedException Exception
     */
    public function test_get_method_not_available()
    {
        $client = new TestClient('http://localhost');
        $client->get('does_not_exist');
    }

    /**
     * @covers Exads\TestClient
     * @test
     * @expectedException Exception
     */
    public function test_delete_method_not_available()
    {
        $client = new TestClient('http://localhost');
        $client->delete('does_not_exist');
    }

    /**
     * @covers Exads\TestClient
     * @test
     */
    public function test_post_method_not_available()
    {
        $returnData = 'some data';
        $client = new TestClient('http://localhost');
        $this->assertSame($returnData, $client->post('does_not_exist', $returnData));
    }

    /**
     * @covers Exads\TestClient
     * @test
     */
    public function test_put_method_not_available()
    {
        $returnData = 'some data';
        $client = new TestClient('http://localhost');
        $this->assertSame($returnData, $client->put('does_not_exist', $returnData));
    }
}
