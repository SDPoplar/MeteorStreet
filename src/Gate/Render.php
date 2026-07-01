<?php
namespace Mxs\Gate;

interface Render
{
    public function onSuccess(mixed $response): void;
    public function onException(\Throwable $e): bool;
}
