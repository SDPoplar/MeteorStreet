<?php
namespace Mxs\Abstracts;

abstract class Singleton
{
    final public static function &get(): Singleton
    {
        $type = static::class;
        if (!array_key_exists($type, self::$dict)) {
            self::$dict[$type] = new $type();
        }
        return self::$dict[$type];
    }

    private static array $dict = [];
}
