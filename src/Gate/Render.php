<?php
namespace Mxs\Gate;

interface Render
{
    public function onSuccess(mixed $response): void;
    public function onException(\Throwable $e): bool;
    public function onError(int $errno, string $errstr, string $errfile, int $errline): bool;
}
