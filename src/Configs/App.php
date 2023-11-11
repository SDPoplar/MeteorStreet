<?php
namespace Mxs\Configs;

class App
{
    public function __construct(
        public readonly bool $debug = false,
        string $db_config_type = '',
        string $cache_config_type = '',
    ) {
        if (!empty($db_config_type)) {
            $this->database = new $db_config_type();
        }

        if (!empty($cache_config_type)) {
            $this->cache = new $cache_config_type();
        }
    }

    /*
    protected static function env(string $filed, $dev_val)
    {}
    */

    public readonly Database $database;
    public readonly Cache $cache;
}
