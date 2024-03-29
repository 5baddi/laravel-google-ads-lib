<?php
namespace BADDIGroup\GoogleAds;


use BADDIGroup\GoogleAds\Auth\OAuth2;
use BADDIGroup\GoogleAds\Reports\Fields;
use BADDIGroup\GoogleAds\Reports\Format;
use BADDIGroup\GoogleAds\Reports\Report;
use BADDIGroup\GoogleAds\Reports\ReportTypes;
use BADDIGroup\GoogleAds\Services\AdGroup;
use BADDIGroup\GoogleAds\Services\AdGroupAd;
use BADDIGroup\GoogleAds\Services\Campaign;
use BADDIGroup\GoogleAds\Services\Service;
use BADDIGroup\GoogleAds\Session\AdwordsSession;

class GoogleAds
{

    /**
     * Full config data.
     *
     * @var mixed
     */
    protected $config;

    /**
     * Access level => test/production
     * @var
     */
    protected $accessLevel;

    /**
     * OAuth UserRefreshCredentials
     * @var
     */
    protected $userCredentials;

    /**
     * Session.
     * @var
     */
    protected $session;

    /**
     * Service
     * @var
     */
    protected $service;

    /**
     * GoogleAds constructor.
     * @param null $accessLevel
     */
    public function __construct($accessLevel = null)
    {
        $this->config = e_ads_config();

        $this->accessLevel = $accessLevel ?: $this->config['level'] ;
    }

    /**
     * Generate User Credentials.
     *
     * @param array $data
     * @return $this
     */
    public function OAuth(array $data = [])
    {
        $this->userCredentials = (new OAuth2())->userCredentials($data);

        return $this;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function session(array $data = [])
    {
        if(!$this->userCredentials){
            $this->session = new AdwordsSession();
            $this->session->OAuth($this->accessLevel);
        }else{
            $this->session = new AdwordsSession($this->userCredentials,$this->accessLevel);
        }


        $this->session = $this->session->build($data);

        return $this;
    }

    /**
     * Get an instance of Fields
     *
     * @return Fields
     */
    public function fields()
    {
      return new Fields($this->session);
    }

    //////////////////////////////////
    //SERVICES
    /////////////////////////////////

    /**
     * Set the google adwords service.
     *
     * @param \Google\AdsApi\AdWords\v201809\cm\*  $service
     * @param \Google\AdsApi\AdWords\AdWordsSession|null $session
     * @return Service
     */
    public function service($service,$session = null)
    {
        $this->service = (new Service($service,$session ?: $this->session));

        return $this->service;
    }

    /**
     * AdGroupService
     * @return AdGroup
     */
    public function adGroupService()
    {
        return new AdGroup($this->session);
    }

    /**
     * AdGroupAdService
     * @return AdGroupAd
     */
    public function adGroupAdService()
    {
        return new AdGroupAd($this->session);
    }

    /**
     * CampaignService
     * @return Campaign
     */
    public function campaignService()
    {
        return new Campaign($this->session);
    }


    /////////////////////////////////
    //REPORTS
    /////////////////////////////////

    /**
     * Get an instance of Report
     * @return Report
     */
    public function report()
    {
        return new Report($this->session);
    }

    /**
     * Show a list of report types
     *
     * @return array
     */
    public function showReportTypes()
    {
        return ReportTypes::getList();
    }

    /**
     * Show a list of report formats.
     * @return array
     */
    public function showReportFormats()
    {
        return Format::getList();
    }

    /////////////////////////////////
    //GETTERS AND SETTERS
    /////////////////////////////////

    /**
     * Get the service.
     *
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Get the session.
     *
     * @return \BADDIGroup\GoogleAds\Session\AdwordsSession
     */
    public function getSession()
    {
        return $this->session;
    }

    /**
     * Get UserRefreshCredentials
     *
     * @return \Google\Auth\Credentials\UserRefreshCredentials
     */
    public function getUserCredentials()
    {
        return $this->userCredentials;
    }

    /**
     * Set the access level of the current account manager.
     *
     * @param $accessLevel
     * @return $this
     */
    public function setAccessLevel($accessLevel){
        $this->accessLevel = $accessLevel;

        return $this;
    }

    /**
     * Get the access level of current account manager.
     * @return null
     */
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }

}