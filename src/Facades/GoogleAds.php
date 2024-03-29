<?php namespace BADDIGroup\GoogleAds\Facades;

use BADDIGroup\GoogleAds\GoogleAds as AliasGoogleAds;
use Illuminate\Support\Facades\Facade;

class GoogleAds extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return AliasGoogleAds::class; }

}