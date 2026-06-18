<?php
namespace Mxs\Routes;

interface Router
{
    public function buildCacheContent(array $rules): array;
    public function routeMatch(string $path, array $cached, ?array &$routeParams): ?Action;
}
