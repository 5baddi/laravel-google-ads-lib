<?php
/**
 * Project: google-ads.
 * User: Edujugon
 * Email: edujugon@gmail.com
 * Date: 9/2/17
 * Time: 11:50
 */

namespace BADDIGroup\GoogleAds\Auth;


use Google\AdsApi\Common\OAuth2TokenBuilder;
use Google\Auth\OAuth2 as GoogleOAuth2;

class OAuth2
{

    /**
     * Adwords config data based on the environment.
     * @var mixed
     */
    protected $adsConfig;

    protected $OAuthConfig;

    /**
     * OAuth2 constructor.
     * @param null $accessLevel
     */
    function __construct($accessLevel = null)
    {
        $this->adsConfig = googleAdsConfig($accessLevel);
        $this->OAuthConfig = OAuthConfig();
    }

    /**
     * UserRefreshCredentials
     * Generate a refreshable OAuth2 credential for authentication.
     *
     * Parameters:
     * $data: [$clientId => '',$clientSecret => '',$refreshToken => '']
     *
     * @param array $data
     * @return \Google\Auth\Credentials\UserRefreshCredentials
     */
    public function userCredentials(array $data = [])
    {

        $data = $this->mergeData($data);

        $refreshCredentials = new OAuth2TokenBuilder();

        return $refreshCredentials->withClientId($data['clientId'])
            ->withClientSecret($data['clientSecret'])
            ->withRefreshToken($data['refreshToken'])
            ->build();
    }

    /**
     * @return \Google\Auth\OAuth2
     */
    public function build()
    {
        $arrayClient = [
            'clientId' => $this->adsConfig['clientId'],
            'clientSecret' => $this->adsConfig['clientSecret']

        ];

        return new GoogleOAuth2(array_merge($this->OAuthConfig, $arrayClient));
    }

    /**
     * Create an array merging the config array with passed data.
     * @param $data
     * @return array
     */
    private function mergeData(array $data)
    {
        return array_merge($this->adsConfig, $data);
    }

}