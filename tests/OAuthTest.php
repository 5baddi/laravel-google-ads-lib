<?php

use PHPUnit\Framework\TestCase;
use BADDIGroup\GoogleAds\Auth\OAuth2;

class OAuthTest extends TestCase {

    /** @test */
    public function new_login(){

        $this->assertInstanceOf('Google\Auth\Credentials\UserRefreshCredentials',(new OAuth2())->userCredentials());
    }

    /** @test */
    public function login_with_parameters()
    {
        $OAuth = new OAuth2();

        $refreshToken = $OAuth->userCredentials([
            'clientId' => 'test',
            'clientSecret' => 'test',
            'refreshToken' => 'TEST'
        ]);

        $this->assertInstanceOf('Google\Auth\Credentials\UserRefreshCredentials',$refreshToken);
    }

    /** @test */
    public function build_passing_env()
    {
        $OAuth = new OAuth2('production');
        $this->assertInstanceOf('Google\Auth\Credentials\UserRefreshCredentials',$OAuth->userCredentials());
    }

    /** @test */
    public function get_full_authorization_uri()
    {
        $OAuth = new OAuth2();
        $this->assertInternalType('string',$OAuth->build()->buildFullAuthorizationUri()->getQuery());
    }
}