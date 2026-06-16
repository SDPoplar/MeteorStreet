<?php
namespace Mxs\Routes\Codecs;

interface CodecInterface
{
    public function buildCacheContent(array $rules): array;
    public function routeMatch(string $path, array $cached, ?array &$routeParams): ?\Mxs\Routes\Action;
}
