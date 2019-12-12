<?php

use PHPUnit\Framework\TestCase;

class GlobalFunctionWrappers extends TestCase{

    /** @test */
    public function getReportByGlobalWrapper()
    {
        $this->assertInstanceOf(\BADDIGroup\GoogleAds\Reports\Report::class, googleReport());
    }

    /** @test */
    public function getServiceByGlobalWrapper()
    {
        $this->assertInstanceOf(\BADDIGroup\GoogleAds\Services\Service::class, googleService(\Google\AdsApi\AdWords\v201809\cm\CampaignService::class));
    }

    /** @test */
    public function getReportFieldClassByGlobalWrapper()
    {
        $this->assertInstanceOf(\BADDIGroup\GoogleAds\Reports\Fields::class, googleReportFields());
    }

}