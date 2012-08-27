<?php

class ViewTest extends PHPUnit_Extensions_SeleniumTestCase
{
    public static $browsers = array(
        array(
            'name'=>'Chrome on Mac',
            'browser'=>'*googlechrome',
            'port'=>4444,
            'host'=>'localhost',
            'timeout'=>30000
        ),
        array(
            'name'=>'Safari on Mac',
            'browser'=>'*safari',
            'port'=>4444,
            'host'=>'localhost',
            'timeout'=>30000
        )
    );

    public function setUp()
    {
        $this->setBrowserUrl('http://localhost:8080');
    }

    /**
     * @test
     * Test that the title is correct in all browsers
     */
    public function TestTitleInAllBrowsers()
    {
        $this->open('/');
        $this->assertTitle('My Test Page');
        $this->assertElementContainsText('//body','Matt');
    }
}