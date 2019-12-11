<?php
namespace BADDIGroup\GoogleAds\Console;

use BADDIGroup\GoogleAds\Auth\OAuth2;
use Illuminate\Console\Command;

class RefreshTokenCommand extends Command {

    /**
     * Console command signature
     *
     * @var string
     */
    protected $signature = 'googleads:generate:refresh-token';

    /**
     * Description
     *
     * @var string
     */
    protected $description = 'Generate a new refresh token for Google Adwords API';

    /**
     * Generate refresh token
     *
     */
    public function handle()
    {

        $OAuth2 = (new OAuth2())->build();

        $authorizationUrl = $OAuth2->buildFullAuthorizationUri();

        // Show authorization URL
        $this->line(sprintf(
            "Log into the Google account you use for AdWords and visit the following URL:\n%s",
            $authorizationUrl
        ));
        // Retrieve token
        $accessToken = $this->ask('After approving the token enter the authorization code here:');

        $OAuth2->setCode($accessToken);
        $authToken = $OAuth2->fetchAuthToken();

        if (!array_key_exists('refresh_token', $authToken)) {
            $this->error('Couldn\'t find refresh_token key in the response.');
            $this->comment('Below you can check the whole response:');
            $this->line(json_encode($authToken));

            return;
        }

        $this->comment('Copy the refresh token in your googleads configuration file (config/googleads.php)');

        // Print refresh token
        $this->line(sprintf(
            'Refresh token: "%s"',
            $authToken['refresh_token']
        ));
    }

}