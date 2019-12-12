<?php
/**
 * Project: google-ads.
 * User: Edujugon
 * Email: edujugon@gmail.com
 * Date: 9/2/17
 * Time: 13:27
 */

namespace BADDIGroup\GoogleAds\Session;

use BADDIGroup\GoogleAds\Auth\OAuth2;
use Google\AdsApi\AdWords\AdWordsSessionBuilder;

class AdwordsSession
{

    /**
     * @var
     */
    protected $OAuth2Credential;

    /**
     * Adwords config data based on the environment.
     * @var mixed
     */
    protected $adsConfig;

    /**
     * AdwordsSession constructor.
     * @param $OAuth2Credential
     * @param null $env
     */
    function __construct($OAuth2Credential = null, $env = null)
    {
        if($OAuth2Credential)
            $this->OAuth2Credential = $OAuth2Credential;

        $this->adsConfig = googleAdsConfig($env);
    }

    /**
     * Create OAuth2 credential
     *
     * @param null $env
     * @param array|null $data
     * @return $this
     */
    public function OAuth($env = null, $data = [])
    {
        $this->OAuth2Credential = (new OAuth2($env))->userCredentials($data);

        return $this;

    }

    /**
     * Construct an API session configured from global config data file or passed data
     *
     * @param array $data
     * @return mixed
     */
    public function build(array $data = [])
    {
        if(!$this->OAuth2Credential)
            $this->OAuth();

        $data = $this->mergeData($data);

        $adwordsSession = new AdWordsSessionBuilder();

        return $adwordsSession->withDeveloperToken($data['developerToken'])
                ->withClientCustomerId($data['clientCustomerId'])
                ->withOAuth2Credential($this->OAuth2Credential)
                ->build();
    }

    /**
     * Construct an API session from OAuth2
     *
     * @param string $developerToken
     * @param \Google\Auth\Credentials\UserRefreshCredentials $OAuth2Credential
     * @return mixed
     */
    public function buildWithOAuth($developerToken, $OAuth2Credential)
    {
        $adwordsSession = new AdWordsSessionBuilder();

        return $adwordsSession->withDeveloperToken($developerToken)
            ->withOAuth2Credential($OAuth2Credential)
            ->build();
    }

    /**
     * Create an array merging the config array with passed data.
     *
     * @param $data
     * @return array
     */
    private function mergeData(array $data)
    {
        return array_merge($this->adsConfig,$data);
    }
}