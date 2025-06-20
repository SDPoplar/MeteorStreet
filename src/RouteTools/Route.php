<?php
namespace Mxs\RouteTools;

abstract class Route
{
    public static function group(callable $group_register): RouteGroup
    {
        $group = new RouteGroup();
        $group_register($group);
        return $group;
    }

    public static function get(string $url): RouteRule
    {
        return self::rule($url, \SeaDrip\Http\Method::GET->value);
    }

    public static function post(string $url): RouteRule
    {
        return self::rule($url, \SeaDrip\Http\Method::POST->value);
    }

    public static function cli(string $command): RouteRule
    {
        return self::rule($command, 'cli');
    }

    protected static function rule(string $patten, string $method): RouteRule
    {
        return new RouteRule($patten, $method);
    }
}
