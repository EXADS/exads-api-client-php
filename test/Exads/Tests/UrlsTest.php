<?php

namespace Exads\Tests;

use Exads\TestUrlClient;

class UrlsTest extends \PHPUnit_Framework_TestCase
{
    /** @var TestUrlClient */
    private $client;

    public function setup()
    {
        $this->client = new TestUrlClient('http://localhost');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function test_invalid_api_name()
    {
        $this->client->bla;
    }

    /**
     * @test
     */
    public function test_campaigns_methods()
    {
        $res = $this->client->api('campaigns')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns'));

        $res = $this->client->api('campaigns')->groups();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns/groups'));

        $res = $this->client->api('campaigns')->show(1);
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns/1'));

        $res = $this->client->api('campaigns')->copy(1);
        $this->assertEquals($res, array('method' => 'PUT', 'path' => 'campaigns/1/copy'));

        $res = $this->client->api('campaigns')->remove(array(1));
        $this->assertEquals($res, array(
            'method' => 'PUT',
            'path' => 'campaigns/delete',
            'data' => array(1),
        ));

        $res = $this->client->api('campaigns')->pause(array(1));
        $this->assertEquals($res, array(
            'method' => 'PUT',
            'path' => 'campaigns/pause',
            'data' => array(1),
        ));

        $res = $this->client->api('campaigns')->play(array(1));
        $this->assertEquals($res, array(
            'method' => 'PUT',
            'path' => 'campaigns/play',
            'data' => array(1),
        ));

        $res = $this->client->api('campaigns')->restore(array(1));
        $this->assertEquals($res, array(
            'method' => 'PUT',
            'path' => 'campaigns/restore',
            'data' => array(1),
        ));

        $res = $this->client->campaigns->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns'));

        $res = $this->client->campaigns->show(1);
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns/1'));

        $res = $this->client->campaigns->copy(1);
        $this->assertEquals($res, array('method' => 'PUT', 'path' => 'campaigns/1/copy'));

        $res = $this->client->campaigns->remove(array(1, 2));
        $this->assertEquals($res, array(
            'method' => 'PUT',
            'path' => 'campaigns/delete',
            'data' => array(1, 2),
        ));

        $res = $this->client->campaigns->pause(array(1, 2));
        $this->assertEquals($res, array(
            'method' => 'PUT',
            'path' => 'campaigns/pause',
            'data' => array(1, 2),
        ));

        $res = $this->client->campaigns->play(array(1, 2));
        $this->assertEquals($res, array(
            'method' => 'PUT',
            'path' => 'campaigns/play',
            'data' => array(1, 2),
        ));

        $res = $this->client->campaigns->restore(array(1, 2));
        $this->assertEquals($res, array(
            'method' => 'PUT',
            'path' => 'campaigns/restore',
            'data' => array(1, 2),
        ));
    }

    /**
     * @test
     * @dataProvider getValidElementTypes
     */
    public function test_campaigns_methods_with_element_type($elementType)
    {
        $res = $this->client->api('campaigns')->addElement($elementType, 1, 'targeted');
        $this->assertEquals($res, array('method' => 'POST', 'path' => 'campaigns/1/targeted/'.$elementType));

        $res = $this->client->api('campaigns')->replaceElement($elementType, 2, 'blocked');
        $this->assertEquals($res, array('method' => 'PUT', 'path' => 'campaigns/2/blocked/'.$elementType));

        $res = $this->client->api('campaigns')->removeElement($elementType, 3, 'targeted');
        $this->assertEquals($res, array('method' => 'DELETE', 'path' => 'campaigns/3/targeted/'.$elementType));

        if ('countries' !== $elementType) {
            $res = $this->client->api('campaigns')->removeAllElements($elementType, 4, 'targeted');
            $this->assertEquals($res, array('method' => 'DELETE', 'path' => 'campaigns/4/targeted/'.$elementType.'/all'));
        }

        $res = $this->client->campaigns->addElement($elementType, 1, 'targeted');
        $this->assertEquals($res, array('method' => 'POST', 'path' => 'campaigns/1/targeted/'.$elementType));

        $res = $this->client->campaigns->replaceElement($elementType, 2, 'blocked');
        $this->assertEquals($res, array('method' => 'PUT', 'path' => 'campaigns/2/blocked/'.$elementType));

        $res = $this->client->campaigns->removeElement($elementType, 3, 'targeted');
        $this->assertEquals($res, array('method' => 'DELETE', 'path' => 'campaigns/3/targeted/'.$elementType));

        if ('countries' !== $elementType) {
            $res = $this->client->campaigns->removeAllElements($elementType, 4, 'targeted');
            $this->assertEquals($res, array('method' => 'DELETE', 'path' => 'campaigns/4/targeted/'.$elementType.'/all'));
        }
    }

    public function getValidElementTypes()
    {
        return array(
            array('browsers'),
            array('carriers'),
            array('categories'),
            array('countries'),
            array('devices'),
            array('languages'),
            array('operating_systems'),
            array('sites'),
            array('keywords'),
            array('ip_ranges'),
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function test_campaigns_methods_with_invalid_element_type()
    {
        $this->client->api('campaigns')->addElement('bla', 1, 'targeted');

        $this->client->campaigns->addElement('bla', 1, 'targeted');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function test_campaigns_methods_with_invalid_element_type2()
    {
        $this->client->api('campaigns')->replaceElement('bla', 1, 'blocked');

        $this->client->campaigns->replaceElement('bla', 1, 'blocked');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function test_campaigns_methods_with_invalid_element_type3()
    {
        $this->client->api('campaigns')->removeElement('bla', 1, 'targeted');

        $this->client->campaigns->removeElement('bla', 1, 'targeted');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function test_campaigns_methods_with_invalid_element_type4()
    {
        $this->client->api('campaigns')->removeAllElements('bla', 1, 'targeted');

        $this->client->campaigns->removeAllElements('bla', 1, 'targeted');
    }

    /**
     * @test
     */
    public function test_login_methods()
    {
        $res = $this->client->api('login')->getToken('aaa', 'bbb');
        $this->assertEquals($res, array(
            'method' => 'POST',
            'path' => 'login',
            'data' => array('username' => 'aaa', 'password' => 'bbb'),
        ));

        $res = $this->client->login->getToken('aaa', 'bbb');
        $this->assertEquals($res, array(
            'method' => 'POST',
            'path' => 'login',
            'data' => array('username' => 'aaa', 'password' => 'bbb'),
        ));

        $res = $this->client->api('login')->getToken('aaa');
        $this->assertEquals($res, array(
            'method' => 'POST',
            'path' => 'login',
            'data' => array('api_token' => 'aaa'),
        ));

        $res = $this->client->login->getToken('aaa');
        $this->assertEquals($res, array(
            'method' => 'POST',
            'path' => 'login',
            'data' => array('api_token' => 'aaa'),
        ));
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

        $res = $this->client->collections->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections'));

        $res = $this->client->collections->browsers();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/browsers'));

        $res = $this->client->collections->carriers();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/carriers'));

        $res = $this->client->collections->categories();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/categories'));

        $res = $this->client->collections->devices();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/devices'));

        $res = $this->client->collections->languages();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/languages'));

        $res = $this->client->collections->os();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'collections/operating-systems'));
    }

    /**
     * @test
     */
    public function test_payments_advertiser_methods()
    {
        $res = $this->client->api('payments_advertiser')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'payments/advertiser'));

        $res = $this->client->payments_advertiser->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'payments/advertiser'));
    }

    /**
     * @test
     */
    public function test_payments_publisher_methods()
    {
        $res = $this->client->api('payments_publisher')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'payments/publisher'));

        $res = $this->client->payments_publisher->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'payments/publisher'));
    }

    /**
     * @test
     */
    public function test_sites_methods()
    {
        $res = $this->client->api('sites')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'sites'));

        $res = $this->client->sites->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'sites'));
    }

    /**
     * @test
     */
    public function test_statistics_advertiser_methods()
    {
        $res = $this->client->api('statistics_advertiser')->browser();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/browser'));

        $res = $this->client->api('statistics_advertiser')->campaign();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/campaign'));

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

        $res = $this->client->statistics_advertiser->browser();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/browser'));

        $res = $this->client->statistics_advertiser->campaign();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/campaign'));

        $res = $this->client->statistics_advertiser->carrier();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/carrier'));

        $res = $this->client->statistics_advertiser->category();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/category'));

        $res = $this->client->statistics_advertiser->country();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/country'));

        $res = $this->client->statistics_advertiser->date();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/date'));

        $res = $this->client->statistics_advertiser->device();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/device'));

        $res = $this->client->statistics_advertiser->hour();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/hour'));

        $res = $this->client->statistics_advertiser->os();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/os'));

        $res = $this->client->statistics_advertiser->site();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/site'));

        $res = $this->client->statistics_advertiser->language();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/language'));

        $res = $this->client->statistics_advertiser->variation();
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

        $res = $this->client->statistics_publisher->browser();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/browser'));

        $res = $this->client->statistics_publisher->carrier();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/carrier'));

        $res = $this->client->statistics_publisher->category();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/category'));

        $res = $this->client->statistics_publisher->language();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/language'));

        $res = $this->client->statistics_publisher->country();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/country'));

        $res = $this->client->statistics_publisher->date();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/date'));

        $res = $this->client->statistics_publisher->device();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/device'));

        $res = $this->client->statistics_publisher->hour();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/hour'));

        $res = $this->client->statistics_publisher->os();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/os'));

        $res = $this->client->statistics_publisher->site();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/site'));

        $res = $this->client->statistics_publisher->sub();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/sub'));

        $res = $this->client->statistics_publisher->zone();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/zone'));
    }

    /**
     * @test
     */
    public function test_user_methods()
    {
        $res = $this->client->api('user')->show();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'user'));

        $res = $this->client->api('user')->update(array('firstname' => 'asdf'));
        $this->assertEquals($res, array(
            'method' => 'PUT',
            'path' => 'user',
            'data' => array('firstname' => 'asdf'),
        ));

        $res = $this->client->api('user')->changepassword('asdf', 'asdf_new');
        $this->assertEquals($res, array(
            'method' => 'POST',
            'path' => 'user/changepassword',
            'data' => array('password' => 'asdf', 'new_password' => 'asdf_new'),
        ));

        $res = $this->client->api('user')->resetpassword('asdf@asdf.com', 'asdf');
        $this->assertEquals($res, array(
            'method' => 'POST',
            'path' => 'user/resetpassword',
            'data' => array('email' => 'asdf@asdf.com', 'username' => 'asdf', 'token' => null),
        ));

        $res = $this->client->user->show();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'user'));

        $res = $this->client->user->update(array('firstname' => 'asdf'));
        $this->assertEquals($res, array(
            'method' => 'PUT',
            'path' => 'user',
            'data' => array('firstname' => 'asdf'),
        ));

        $res = $this->client->user->changepassword('asdf', 'asdf_new');
        $this->assertEquals($res, array(
            'method' => 'POST',
            'path' => 'user/changepassword',
            'data' => array('password' => 'asdf', 'new_password' => 'asdf_new'),
        ));

        $res = $this->client->user->resetpassword('asdf@asdf.com', 'asdf');
        $this->assertEquals($res, array(
            'method' => 'POST',
            'path' => 'user/resetpassword',
            'data' => array('email' => 'asdf@asdf.com', 'username' => 'asdf', 'token' => null),
        ));
    }

    /**
     * @test
     */
    public function test_zone_methods()
    {
        $res = $this->client->api('zones')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'zones'));

        $res = $this->client->zones->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'zones'));
    }

    /**
     * @test
     */
    public function test_get_parameters_presence()
    {
        $res = $this->client->api('campaigns')->all(array('offset' => 100));
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns?offset=100'));

        $res = $this->client->campaigns->all(array('offset' => 100));
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns?offset=100'));
    }
}
