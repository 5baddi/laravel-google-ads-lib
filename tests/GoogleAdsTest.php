<?php

use PHPUnit\Framework\TestCase;
use BADDIGroup\GoogleAds\GoogleAds;
use BADDIGroup\GoogleAds\Reports\MyReport;
use Google\AdsApi\AdWords\v201809\cm\AdGroupService;
use Google\AdsApi\AdWords\v201809\cm\CampaignService;

class GoogleAdsTest extends TestCase {


    /** @test */
    public function setAccessLevel(){

        $ads = new GoogleAds();

        $ads->setAccessLevel('test');

        $this->assertEquals('test', $ads->getAccessLevel());
    }

    /** @test */
    public function OAuth()
    {
        $ads = new GoogleAds();

        $ads->OAuth();

        $this->assertInstanceOf('Google\Auth\Credentials\UserRefreshCredentials', $ads->getUserCredentials());
    }

    /** @test */
    public function OAuthParameters()
    {
        $ads = new GoogleAds();

        $ads->OAuth([
            'clientId'      => 'test',
            'clientSecret'  => 'test',
            'refreshToken'  => 'TEST'
        ]);

        $this->assertInstanceOf('Google\Auth\Credentials\UserRefreshCredentials', $ads->getUserCredentials());
    }

    /** @test */
    public function createSession()
    {
        $ads = new GoogleAds();

        $session = $ads->session();

        $this->assertInstanceOf(Google\AdsApi\AdWords\AdWordsSession::class, $session->getSession());
    }

    /** @test */
    public function createServiceInstance()
    {
        $ads = new GoogleAds();

        $ads = $ads->service(CampaignService::class);

        $this->assertInstanceOf(CampaignService::class, $ads->getService());
    }

    /** @test */
    public function get_all_items_of_campaign_service()
    {
        $ads = new GoogleAds();

        $campaigns = $ads->service(CampaignService::class)->select(['Id'])->get();

        $this->assertInstanceOf(\BADDIGroup\GoogleAds\Services\ServiceCollection::class,$campaigns);
    }

    /** @test */
    public function adGroupServiceInstance()
    {
        $ads = new GoogleAds();

        $adGroup = $ads->adGroupService();

        $this->assertInstanceOf(AdGroupService::class, $adGroup->getService());
    }

    /** @test */
    public function get_all_items_of_adGroup_service()
    {
        $ads = new GoogleAds();

        $adGroup = $ads->session()->adGroupService()->get();

        $this->assertInstanceOf(\BADDIGroup\GoogleAds\Services\ServiceCollection::class,$adGroup);
    }

    /** @test */
    public function get_all_items_of_adGroupAd_service()
    {
        $ads = new GoogleAds();

        $adGroup = $ads->adGroupAdService()->get();

        $this->assertInstanceOf(\BADDIGroup\GoogleAds\Services\ServiceCollection::class,$adGroup);
    }

    /** @test */
    public function get_all_items_of_campaign_service_by_direct_method()
    {
        $ads = new GoogleAds();

        $adGroup = $ads->campaignService()->get();

        $this->assertInstanceOf(\BADDIGroup\GoogleAds\Services\ServiceCollection::class,$adGroup);
    }


    ///////////////////////
    // Reports
    ///////////////////////

    /** @test */
    public function show_all_fields_of_a_report_type()
    {
        $ads = new GoogleAds();

        $fields = $ads->fields()->of('CRITERIA_PERFORMANCE_REPORT')->asList();

        $this->assertIsArray($fields);
    }

    /** @test */
    public function create_instance_of_report()
    {
        $ads = new GoogleAds();

        $this->assertInstanceOf(\BADDIGroup\GoogleAds\Reports\Report::class,$ads->report());
    }

    /** @test */
    public function get_report_as_object()
    {
        $ads = new GoogleAds();
        $string = $ads->report()->select('CampaignId','AdGroupId','AdGroupName','Id', 'Criteria', 'CriteriaType','Impressions', 'Clicks', 'Cost', 'UrlCustomParameters')
            ->from('CRITERIA_PERFORMANCE_REPORT')
            ->during('20170101','20170210')
            ->format('XML')
            ->where('CampaignId = 752331963')
            ->getAsString();

        $this->assertInternalType('string',$string);
    }

    /** @test */
    public function get_report_types()
    {
        $ads = new GoogleAds();

        $this->assertIsArray($ads->showReportTypes());
    }

    /** @test */
    public function get_formats()
    {
        $ads = new GoogleAds();

        $this->assertIsArray($ads->showReportFormats());
    }

    /** @test */
    public function get_report_string()
    {
        $ads = new GoogleAds();

        $string = $ads->report()
            ->format('CSVFOREXCEL')
            ->select('CampaignId','AdGroupId','AdGroupName','Id', 'Criteria', 'CriteriaType','Impressions', 'Clicks', 'Cost', 'UrlCustomParameters')
            ->from('CRITERIA_PERFORMANCE_REPORT')
            ->getAsString();

        $this->assertInternalType('string',$string);
    }

    /** @test */
    public function get_my_report_object()
    {
        $ads = new GoogleAds();
        $obj = $ads->report()->from('CRITERIA_PERFORMANCE_REPORT')
            ->during('20170101','20170210')
            ->where('CampaignId = 752331963')
            ->select('CampaignId','AdGroupId','AdGroupName','Id', 'Criteria', 'CriteriaType','Impressions', 'Clicks', 'Cost', 'UrlCustomParameters')
            ->getAsObj();

        $this->assertInstanceOf(MyReport::class,$obj);
    }

    /** @test */
    public function get_fields_of_a_report_type()
    {
        $ads = new GoogleAds();
        $fields = $ads->report()->from('CRITERIA_PERFORMANCE_REPORT')->getFields();
        $this->assertIsArray($fields);
    }

    /** @test */
    public function get_report_formats()
    {
        $ads = new GoogleAds();
        $this->assertIsArray($ads->report()->getFormats());
    }
}