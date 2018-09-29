<?php
namespace Main;

use E4u\Configuration as E4uConfiguration;
use Zend\Config\Config;

abstract class Configuration extends E4uConfiguration
{
    /** @var Config */
    private static $_config;

    /**
     * @return Config
     */
    public static function facebookConfig()
    {
        return self::getConfigValue('facebook');
    }

    /**
     * @return Config
     */
    public static function googleConfig()
    {
        return self::getConfigValue('google');
    }

    /**
     * @return Config
     */
    public static function twitterConfig()
    {
        return self::getConfigValue('twitter');
    }

    /**
     * @return Config
     */
    public static function steamConfig()
    {
        return self::getConfigValue('steam');
    }
}