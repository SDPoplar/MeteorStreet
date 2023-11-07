<?php
namespace Mxs\Channels;

abstract class DriverManager
{
    public static function &pdo(string $dsn, string $user_name, string $password, array $options = []): \PDO
    {
        $key = "pdo - {$dsn}";
        if (!array_key_exists($key, self::$drivers)) {
            self::$drivers[$key] = new \PDO($dsn, $user_name, $password, $options);
        }
        return self::$drivers[$key];
    }
    protected static array $drivers = [];
}
