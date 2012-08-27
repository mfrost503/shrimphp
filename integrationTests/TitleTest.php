<?php

class DBTest extends PHPUnit_Extensions_SeleniumTestCase
{
    public function setUp(){
        $this->setBrowser('*firefox');
        $this->setBrowserUrl('http://localhost/');
    }
    public function tearDown(){}

    /**
    * @test
    **/
    public function CheckHomePageTitle()
    {
        $this->open('http://localhost/');
        $this->assertTitle('My Test Page');
    }

    /**
    * @test
    **/
    public function CheckEmilyPageTitleAndContent()
    {
        $this->open('http://localhost/emily');
        $this->assertTitle('Needing some real bad Emily Action');
        $this->assertElementContainsText('//content','emily');
    }
}
