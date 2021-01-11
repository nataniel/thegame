<?php
namespace Main;

use E4u\Configuration as E4uConfiguration;
use Laminas\Config\Config;

abstract class Configuration extends E4uConfiguration
{
    /** @var Config */
    private static $_config;

    /**
     * @return Config
     */
    public static function facebookConfig(): Config
    {
        return self::getConfigValue('facebook');
    }

    /**
     * @return Config
     */
    public static function googleConfig(): Config
    {
        return self::getConfigValue('google');
    }

    /**
     * @return Config
     */
    public static function twitterConfig(): Config
    {
        return self::getConfigValue('twitter');
    }

    /**
     * @return Config
     */
    public static function steamConfig(): Config
    {
        return self::getConfigValue('steam');
    }
}