<?php

use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase {

    /** @test */
    public function loadConfigFile(){
        $this->assertIsArray(adsConfig());
    }

    /** @test */
    public function loadAdsConfig()
    {
        $this->assertArrayNotHasKey('production', googleAdsConfig('test'));
    }

    /** @test */
    public function passWrongAccessLevel()
    {
        $this->expectException(BADDIGroup\GoogleAds\Exceptions\Config::class);
        $this->expectExceptionMessage('Please provide a correct environment. Available options: production/test');

        googleAdsConfig('nothing');
    }
}