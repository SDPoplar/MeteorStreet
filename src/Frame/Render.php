<?php
namespace Mxs\Frame;

abstract class Render
{
    abstract public function onSuccess($response): void;

    public function __construct($root_input)
    {}

    public function onException(\Throwable $e): bool
    {
        var_dump($e);
        return true;
    }

    public function onError(
        int $errno,
        string $errstr,
        string $errfile,
        int $errline
    ): bool {
        return false;
    }
}
