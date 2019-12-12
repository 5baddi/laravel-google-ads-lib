<?php

use PHPUnit\Framework\TestCase;
use BADDIGroup\GoogleAds\Auth\OAuth2;
use BADDIGroup\GoogleAds\Session\AdwordsSession;



class SessionTest extends TestCase {

    /** @test */
    public function createSession()
    {
        // Generate a refreshable OAuth2 credential for authentication.
        $OAuth2Credential = (new OAuth2())->build();

        $session = (new BADDIGroup\GoogleAds\Session\AdwordsSession($OAuth2Credential))->build();

        $this->assertInstanceOf(Google\AdsApi\AdWords\AdWordsSession::class, $session);
    }

    /** @test */
    public function create_session_with_auto_oauth()
    {
        $session = (new AdwordsSession())->OAuth()->build();

        $this->assertInstanceOf(Google\AdsApi\AdWords\AdWordsSession::class,$session);
    }

    /** @test */
    public function pass_params_to_auto_oauth(){
        $env = 'test';

        $session = (new AdwordsSession(null,$env))->OAuth($env,[
            'clientId' => 'test',
            'clientSecret' => 'test',
            'refreshToken' => 'TEST'
        ])->build();

        $this->assertInstanceOf(Google\AdsApi\AdWords\AdWordsSession::class,$session);
    }

    /** @test */
    public function build_with_parameters()
    {
        $session = (new AdwordsSession())->OAuth()->build([
            'developerToken' => 'token',
            'clientCustomerId' => 'id'
        ]);

        $this->assertInstanceOf(Google\AdsApi\AdWords\AdWordsSession::class,$session);
    }

    /** @test */
    public function create_new_session_with_auto_oauth_login()
    {
        $session = new AdwordsSession();
        $session = $session->build();

        $this->assertInstanceOf(Google\AdsApi\AdWords\AdWordsSession::class,$session);
    }
}