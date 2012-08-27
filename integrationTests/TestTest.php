<?php

class TestTest extends PHPUnit_Extensions_SeleniumTestCase
{

    protected $captureScreenshotOnFailure = TRUE;
    protected $screenshotPath = '/var/www/html/screenshots';
    protected $screenshotUrl = 'http://locahost/screenshots';

    public function setUp()
    {
        
        $this->setBrowser('*firefox');
        $this->setBrowserUrl('http://shortwhitebaldguy.com');
    }

    public function testTitle()
    {
        $this->open('http://shortwhitebaldguy.com');
        $this->assertTitle('short white bald guy >> Pages');
    }
}
