<?php

namespace Exads\Tests;

use Exads\TestUrlClient;

class TestUrlsTest extends \PHPUnit_Framework_TestCase
{
    private $client;

    public function setup()
    {
        $this->client = new TestUrlClient('http://localhost');
    }

    /**
     * @test
     */
    public function test_get_parameters_presence()
    {
        $res = $this->client->api('campaigns')->all(array('offset' => 100));
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns?offset=100'));
    }
    /**
     * @test
     */
    public function test_campaigns_methods()
    {
        $res = $this->client->api('campaigns')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns'));

        $res = $this->client->api('campaigns')->show(1);
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns/1'));

        $res = $this->client->api('campaigns')->copy(1);
        $this->assertEquals($res, array('method' => 'PUT', 'path' => 'campaigns/1/copy'));

        $res = $this->client->api('campaigns')->delete(1);
        $this->assertEquals($res, array('method' => 'PUT', 'path' => 'campaigns/1/delete'));

        $res = $this->client->api('campaigns')->pause(1);
        $this->assertEquals($res, array('method' => 'PUT', 'path' => 'campaigns/1/pause'));

        $res = $this->client->api('campaigns')->play(1);
        $this->assertEquals($res, array('method' => 'PUT', 'path' => 'campaigns/1/play'));

        $res = $this->client->api('campaigns')->restore(1);
        $this->assertEquals($res, array('method' => 'PUT', 'path' => 'campaigns/1/restore'));
    }

    /**
     * @test
     */
    public function test_login_methods()
    {
        $res = $this->client->api('login')->getToken('aaa', 'bbb');
        $this->assertEquals($res, array('method' => 'POST', 'path' => 'login'));
    }

    /**
     * @test
     */
    public function test_collections_methods()
    {
        $res = $this->client->api('collections')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections'));

        $res = $this->client->api('collections')->browsers();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/browsers'));

        $res = $this->client->api('collections')->carriers();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/carriers'));

        $res = $this->client->api('collections')->categories();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/categories'));

        $res = $this->client->api('collections')->devices();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/devices'));

        $res = $this->client->api('collections')->languages();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/languages'));

        $res = $this->client->api('collections')->os();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/operating-systems'));
    }

    /**
     * @test
     */
    public function test_payments_advertiser_methods()
    {
        $res = $this->client->api('payments_advertiser')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'payments/advertiser'));
    }

    /**
     * @test
     */
    public function test_payments_publisher_methods()
    {
        $res = $this->client->api('payments_publisher')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'payments/publisher'));
    }

    /**
     * @test
     */
    public function test_sites_methods()
    {
        $res = $this->client->api('sites')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'sites'));
    }

    /**
     * @test
     */
    public function test_statistics_advertiser_methods()
    {
        $res = $this->client->api('statistics_advertiser')->browser();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/browser'));

        $res = $this->client->api('statistics_advertiser')->carrier();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/carrier'));

        $res = $this->client->api('statistics_advertiser')->category();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/category'));

        $res = $this->client->api('statistics_advertiser')->country();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/country'));

        $res = $this->client->api('statistics_advertiser')->date();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/date'));

        $res = $this->client->api('statistics_advertiser')->device();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/device'));

        $res = $this->client->api('statistics_advertiser')->hour();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/hour'));

        $res = $this->client->api('statistics_advertiser')->os();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/os'));

        $res = $this->client->api('statistics_advertiser')->site();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/site'));

        $res = $this->client->api('statistics_advertiser')->language();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/language'));

        $res = $this->client->api('statistics_advertiser')->variation();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/variation'));
    }

    /**
     * @test
     */
    public function test_statistics_publisher_methods()
    {
        $res = $this->client->api('statistics_publisher')->browser();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/browser'));

        $res = $this->client->api('statistics_publisher')->carrier();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/carrier'));

        $res = $this->client->api('statistics_publisher')->category();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/category'));

        $res = $this->client->api('statistics_publisher')->country();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/country'));

        $res = $this->client->api('statistics_publisher')->date();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/date'));

        $res = $this->client->api('statistics_publisher')->device();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/device'));

        $res = $this->client->api('statistics_publisher')->hour();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/hour'));

        $res = $this->client->api('statistics_publisher')->os();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/os'));

        $res = $this->client->api('statistics_publisher')->site();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/site'));

        $res = $this->client->api('statistics_publisher')->sub();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/sub'));

        $res = $this->client->api('statistics_publisher')->zone();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/zone'));
    }

    /**
     * @test
     */
    public function test_user_methods()
    {
        $res = $this->client->api('user')->show();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'user'));

        $res = $this->client->api('user')->update(array('asdf' => 'asdf'));
        $this->assertEquals($res, array('method' => 'PUT', 'path' => 'user'));

        $res = $this->client->api('user')->changepassword('asdf', 'asdf');
        $this->assertEquals($res, array('method' => 'POST', 'path' => 'user/changepassword'));

        $res = $this->client->api('user')->resetpassword('asdf@asdf.com', 'asdf');
        $this->assertEquals($res, array('method' => 'POST', 'path' => 'user/resetpassword'));
    }

    /**
     * @test
     */
    public function test_zone_methods()
    {
        $res = $this->client->api('zones')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'zones'));
    }
}
