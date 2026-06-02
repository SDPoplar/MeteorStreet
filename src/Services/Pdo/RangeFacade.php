<?php
namespace Mxs\Services\Pdo;

abstract class RangeFacade
{
    public static function __callStatic(string $name, array $arguments): Range
    {
        return new Range()->$name(...$arguments);
    }
}
