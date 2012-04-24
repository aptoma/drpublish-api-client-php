<?php

class DrPublishApiClientConfig
{
    private static $read = false;
    private static $configs;

    /**
     * Gets a config parameter
     * @param string $name
     * @return mixed
     */
    public static function get($name)
    {
        if (self::$read === false) {
            self::readConfig();
        }
        if (isset(self::$configs[$name])) {
            return self::$configs[$name];
        } else {
            return null;
        }
    }

    /**
     * Reads DrPublish config
     * @return void
     */
    public static function readConfig()
    {
        if (file_exists(dirname(__FILE__) . '/../../../AFW/WEB-INF/config/config.prerequisites.php')) {
            include (dirname(__FILE__) . '/../../../AFW/WEB-INF/config/config.prerequisites.php');
            $afwConfigDir = $prerequisites['CONFIG_DIR'] . '/AFW';
        } else {
            $afwConfigDir = dirname(__FILE__) . '/../../../AFW/WEB-INF/config';
        }
        if (file_exists(dirname(__FILE__) . '/../../WEB-INF/config/config.prerequisites.php')) {
            include (dirname(__FILE__) . '/../../WEB-INF/config/config.prerequisites.php');
            $drpConfigDir = $prerequisites['CONFIG_DIR'] . '/AFW';
        } else {
            $drpConfigDir = dirname(__FILE__) . '/../../WEB-INF/config';
        }
        $serialized = file_get_contents($afwConfigDir . '/config.php');
        $afwConfig = unserialize($serialized);
        $serialized = file_get_contents($drpConfigDir . '/config.php');
        $drpConfig = unserialize($serialized);
        self::$configs = array_merge($afwConfig, $drpConfig);
    }
}