<?php
/**
 *
 * Helper functions to be used anywhere.
 *
 * All function names are prefixed by an "e" to prevent possible conflicts with any framework functions
 *
 */
use BADDIGroup\GoogleAds\Exceptions\Config;
use BADDIGroup\GoogleAds\Reports\Fields;
use BADDIGroup\GoogleAds\Reports\Report;
use BADDIGroup\GoogleAds\Services\Service;

/**
 * Get an instance of Report
 * @param null $session
 * @return Report
 */
function googleReport($session = null)
{
    return new Report($session);
}

/**
 * Get an instance of Service
 * @param Google Service $service
 * @param null $session
 * @return Service
 */
function googleService($service, $session = null)
{
    return new Service($service, $session);
}


/**
 * Get an instance of Fields
 *
 * @param null $session
 * @return Fields
 */
function googleReportFields($session = null)
{
    return new Fields($session);
}

/**
 * Get configuration array data.
 *
 * @return array
 */
function adsConfig()
{
    if(function_exists('config_path'))
    {
        if(file_exists(config_path('googleads.php')))
        {
            $configuration = include(config_path('googleads.php'));

            return $configuration;
        }
    }

    $configuration = include(__DIR__ . '/../Config/config.php');

    return $configuration;
}

/**
 * Get the adwords configuration based on the environment.
 * If env is not passed as parameter it'll take the env value from config file.
 *
 * @param null $accessLevel
 * @return mixed
 * @throws Config
 */
function googleAdsConfig($accessLevel = null)
{
    $config = adsConfig();


    if(!is_null($accessLevel) && !array_key_exists($accessLevel, $config))
        throw new Config('Please provide a correct access level. Available options: production/test');

    return !is_null($accessLevel) ? $config[$accessLevel] : $config[$config['level']];
}

/**
 * Get the OAuth2 configuration
 * @return mixed
 */
function OAuthConfig()
{
    $config = adsConfig();

    return $config['OAuth2'];
}