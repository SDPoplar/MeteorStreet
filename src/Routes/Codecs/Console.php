<?php
namespace Mxs\Routes\Codecs;

use Mxs\Routes\Action;
use Override;

class Console implements CodecInterface
{
    #[Override]
    public function buildCacheContent(array $rules): array
    {
        throw new \Exception('Not implemented');
    }

    #[Override]
    public function routeMatch(string $path, array $cached, ?array &$routeParams): ?Action
    {
        throw new \Exception('Not implemented');
    }
}