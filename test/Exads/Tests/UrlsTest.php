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
    public function testInvalidApiName()
    {
        $this->client->bla;
    }

    /**
     * @test
     */
    public function testCampaignsMethods()
    {
        $create = array('method' => 'POST' , 'path' => 'campaigns' , 'data' => array(1));
        $update = array('method' => 'PUT' , 'path' => 'campaigns/2' , 'data' => array(3));
        $createVariation = array('method' => 'POST' , 'path' => 'campaigns/12/variation' , 'data' => array(21));


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

        $res = $this->client->api('campaigns')->create(array(1));
        $this->assertEquals($res, $create);

        $res = $this->client->api('campaigns')->update(2, array(3));
        $this->assertEquals($res, $update);

        $res = $this->client->api('campaigns')->createVariation(12, array(21));
        $this->assertEquals($res, $createVariation);


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

        $res = $this->client->campaigns->create(array(1));
        $this->assertEquals($res, $create);

        $res = $this->client->campaigns->update(2, array(3));
        $this->assertEquals($res, $update);

        $res = $this->client->campaigns->createVariation(12, array(21));
        $this->assertEquals($res, $createVariation);
    }

    /**
     * @test
     * @dataProvider getValidElementTypes
     */
    public function testCampaignsMethodsWithElementTypeTarget($elementType, $targetType, $all)
    {
        $res = $this->client->api('campaigns')->addElement($elementType, 1, $targetType);
        $this->assertEquals($res, array('method' => 'POST', 'path' => "campaigns/1/$targetType/$elementType"));

        $res = $this->client->api('campaigns')->replaceElement($elementType, 2, $targetType);
        $this->assertEquals($res, array('method' => 'PUT', 'path' => "campaigns/2/$targetType/$elementType"));

        $res = $this->client->api('campaigns')->removeElement($elementType, 3, $targetType);
        $this->assertEquals($res, array('method' => 'DELETE', 'path' => "campaigns/3/$targetType/$elementType"));

        if ($all) {
            $res = $this->client->api('campaigns')->removeAllElements($elementType, 4, $targetType);
            $this->assertEquals($res, array('method' => 'DELETE', 'path' => "campaigns/4/$targetType/$elementType/all"));
        }

        $res = $this->client->campaigns->addElement($elementType, 1, $targetType);
        $this->assertEquals($res, array('method' => 'POST', 'path' => "campaigns/1/$targetType/$elementType"));

        $res = $this->client->campaigns->replaceElement($elementType, 2, $targetType);
        $this->assertEquals($res, array('method' => 'PUT', 'path' => "campaigns/2/$targetType/$elementType"));

        $res = $this->client->campaigns->removeElement($elementType, 3, $targetType);
        $this->assertEquals($res, array('method' => 'DELETE', 'path' => "campaigns/3/$targetType/$elementType"));

        if ($all) {
            $res = $this->client->campaigns->removeAllElements($elementType, 4, $targetType);
            $this->assertEquals($res, array('method' => 'DELETE', 'path' => "campaigns/4/$targetType/$elementType/all"));
        }
    }

    public function getValidElementTypes()
    {
        return array(
            array('browsers', 'targeted', true),
            array('browsers', 'blocked', true),
            array('carriers', 'targeted', true),
            array('carriers', 'blocked', true),
            array('categories', 'targeted', false),
            array('countries', 'targeted', false),
            array('devices', 'targeted', true),
            array('devices', 'blocked', true),
            array('languages', 'targeted', true),
            array('languages', 'blocked', true),
            array('operating_systems', 'blocked', true),
            array('operating_systems', 'targeted', true),
            array('sites', 'blocked', true),
            array('sites', 'targeted', true),
            array('keywords', 'targeted', true),
            array('keywords', 'blocked', true),
            array('ip_ranges', 'targeted', true),
            array('ip_ranges', 'blocked', true),
        );
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function testCampaignsMethodsWithInvalidElementType()
    {
        $this->client->api('campaigns')->addElement('bla', 1, 'targeted');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function testCampaignsMethodWithInvalidElmentType2()
    {
        $this->client->campaigns->addElement('bla', 1, 'targeted');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function testCampaignsMethodsWithInvalidElementType3()
    {
        $this->client->api('campaigns')->replaceElement('bla', 1, 'blocked');
    }

    /**
      * @test
      * @expectedException \InvalidArgumentException
      */
    public function testCampaignsMethodsWithInvalidElementType4()
    {
        $this->client->campaigns->replaceElement('bla', 1, 'blocked');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function testCampaignsMethodsWithInvalidElementType5()
    {
        $this->client->api('campaigns')->removeElement('bla', 1, 'targeted');
    }

    /**
      * @test
      * @expectedException \InvalidArgumentException
      */
    public function testCampaignsMethodWithInvalidElementType6()
    {
        $this->client->campaigns->removeElement('bla', 1, 'targeted');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function testCampaignsMethodsWithInvalidElementType7()
    {
        $this->client->api('campaigns')->removeAllElements('bla', 1, 'targeted');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function testCampaignsMethodsWithInvalidElementType8()
    {
        $this->client->campaigns->removeAllElements('bla', 1, 'targeted');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function testCampaignsMethodsWithInvalidElementType9()
    {
        $this->client->campaigns->removeElement('sites', 1, 'argeted');
    }
   
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function testCampaignsMethodsWithInvalidElementType10()
    {
        $this->client->campaigns->removeElement('browsers', 1, 'target');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     * @dataProvider getTargetOnlyElements
     */
    public function testUnsupportedBlockManipulation($element, $op, $accessVia)
    {
        $access = $this->getCampaignObjectVia($accessVia);

        if ($op == "add") {
            $access->addElement($element, 1, 'blocked');
        } elseif ($op == "remove") {
            $access->removeElement($element, 1, 'blocked');
        } elseif ($op == "replace") {
            $access->replaceElement($element, 1, 'blocked');
        }
    }

    public function getTargetOnlyElements()
    {
        return array(
                        array('categories', 'add', 'getter'),
                        array('categories', 'remove', 'getter'),
                        array('categories', 'replace', 'getter'),
                        array('categories', 'add', 'api'),
                        array('categories', 'remove', 'api'),
                        array('categories', 'replace', 'api'),
                        array('countries', 'add', 'getter'),
                        array('countries', 'remove', 'getter'),
                        array('countries', 'replace', 'getter'),
                        array('countries', 'add', 'api'),
                        array('countries', 'remove', 'api'),
                        array('countries', 'replace', 'api'),
                );
    }

    /**
      * @test
      * @expectedException \InvalidArgumentException
      * @dataProvider getDeleteAllUnsuportedElements
      */
    public function testUnsupportedAllManipulation($element, $accessVia, $type)
    {
        $access = $this->getCampaignObjectVia($accessVia);
        $access->removeAllElements($element, 12, $type);
    }

    public function getDeleteAllUnsuportedElements()
    {
        return array(
                        array('categories', 'getter', 'blocked'),
                        array('categories', 'getter', 'targeted'),
                        array('categories', 'api', 'blocked'),
                        array('categories', 'api', 'targeted'),
                        array('countries', 'getter', 'blocked'),
                        array('countries', 'getter', 'targeted'),
                        array('countries', 'api', 'blocked'),
                        array('countries', 'api', 'targeted'),
                );
    }


    /**
     * @test
     */
    public function testLoginMethods()
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
    public function testCollectionsMethods()
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
    public function testPaymentsAdvertiserMethods()
    {
        $res = $this->client->api('payments_advertiser')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'payments/advertiser'));

        $res = $this->client->payments_advertiser->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'payments/advertiser'));
    }

    /**
     * @test
     */
    public function testPaymentsPublisherMethods()
    {
        $res = $this->client->api('payments_publisher')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'payments/publisher'));

        $res = $this->client->payments_publisher->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'payments/publisher'));
    }

    /**
     * @test
     */
    public function testSitesMethods()
    {
        $res = $this->client->api('sites')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'sites'));

        $res = $this->client->sites->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'sites'));
    }

    /**
     * @test
     */
    public function testStatisticsAdvertiserMethods()
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

        $res = $this->client->api('statistics_advertiser')->zone();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/zone'));

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

        $res = $this->client->statistics_advertiser->zone();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/advertiser/zone'));
    }

    /**
     * @test
     */
    public function testStatisticsPublisherMethods()
    {
        $res = $this->client->api('statistics_publisher')->browser();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/browser'));

        $res = $this->client->api('statistics_publisher')->carrier();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/carrier'));

        $res = $this->client->api('statistics_publisher')->category();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/category'));

        $res = $this->client->api('statistics_publisher')->language();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'statistics/publisher/language'));

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
    public function testUserMethods()
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
    public function testZoneMethods()
    {
        $res = $this->client->api('zones')->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'zones'));

        $res = $this->client->zones->all();
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'zones'));
    }


    /**
     *
     * @test
     */
    public function testOfferMethods()
    {
        $offer_all = array('method' => 'GET', 'path' => 'offers');


        $res = $this->client->api('offers')->all();
        $this->assertEquals($res, $offer_all);

        $res = $this->client->offers->all();
        $this->assertEquals($res, $offer_all);
    }

    /**
     * @test
     */
    public function testGetParametersPresence()
    {
        $res = $this->client->api('campaigns')->all(array('offset' => 100));
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns?offset=100'));

        $res = $this->client->campaigns->all(array('offset' => 100));
        $this->assertEquals($res, array('method' => 'GET', 'path' => 'campaigns?offset=100'));
    }

    private function getCampaignObjectVia($accessVia)
    {
        $access = null;

        if ($accessVia == "getter") {
            $access = $this->client->campaigns;
        } elseif ($accessVia == "api") {
            $access = $this->client->api('campaigns');
        }
        return $access;
    }
}
