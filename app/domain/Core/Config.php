<?php namespace Core;

class Config {
    protected static $configInstance;
    protected $config;

    /**
     * Generates a single instance for use through the application via Static method calls
     */
    public static function createInstance()
    {
        return new Config;
    }

    /**
     * Imports configuration stored within the app/config directory
     */
    public static function importConfig()
    {
        $app = include self::get('path') . "/app/config/app.php";
        $database = include self::get('path') . "/app/config/database.php";

        self::$configInstance->storeConfiguration($app, 'app');
        self::$configInstance->storeConfiguration($database, 'database');
    }

    /**
     * Given an array and prefix, stores data that is used throughout the application
     *
     * @param array $data
     * @param $prefix
     */
    protected function storeConfiguration(array $data, $prefix)
    {
        foreach ($data as $key => $value) {
            self::set($prefix . '.' . $key, $value);
        }
    }

    /**
     * Retrieves stored Configuration values
     *
     * @param null $key
     * @return mixed
     */
    public static function get($key = null)
    {
        if (isset(self::$configInstance) === false) {
            self::$configInstance = self::createInstance();
        }

        if (isset($key)) {
            return self::$configInstance->config[$key];
        } else {
            return self::$configInstance->config;
        }
    }

    /**
     * Stores (and overwrites existing) Configuration values.
     *
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        if (isset(self::$configInstance) === false) {
            self::$configInstance = self::createInstance();
        }

        self::$configInstance->config[$key] = $value;
    }
}