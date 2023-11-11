<?php
namespace Mxs\Channels;

abstract class DriverManager
{
    public static function &pdo(\Mxs\Configs\Pdo\PdoConfig $cfg): \PDO
    {
        $key = "pdo - {$cfg->dsn}";
        if (!array_key_exists($key, self::$drivers)) {
            self::$drivers[$key] = new \PDO($cfg->dsn, $cfg->user, $cfg->password, $cfg->options);
        }
        return self::$drivers[$key];
    }
    protected static array $drivers = [];
}
