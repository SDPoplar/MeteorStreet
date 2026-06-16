<?php
namespace Mxs\Frame;

abstract class Render
{
    abstract public function onSuccess(mixed $response): void;
    abstract public function onException(\Throwable $e): bool;

    public function onError(
        int $errno,
        string $errstr,
        string $errfile,
        int $errline
    ): bool {
        return false;
    }
}
