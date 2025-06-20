<?php
namespace Mxs\Routes;

abstract class Route
{
    public static function enumMethods(): array
    {
        $ret = [];
        array_walk(self::$registed, function (Rule $item) use (&$ret) {
            $ret[$item->method] = true;
        });
        return array_keys($ret);
    }

    public static function getRulesByMethod(string $method): array
    {
        return array_filter(self::$registed, fn(Rule $item): bool => $item->method === $method);
    }

    public static function clearRegisted()
    {
        self::$registed = [];
    }

    protected static array $registed = [];
}