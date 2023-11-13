<?php
namespace Mxs\Frame;

interface ResponseRenderable
{
    public function render($response): string;
}

abstract class Render
{
    public function onException(\Exception $e): bool
    {
        var_dump($e);
        return true;
    }

    public function onError(
        int $errno,
        string $errstr,
        string $errfile,
        int $errline,
        array $errcontext
    ): bool {
        return false;
    }
}
