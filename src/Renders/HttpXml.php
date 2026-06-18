<?php
namespace Mxs\Renders;

use Override;

class HttpXml extends Http
{
    #[Override]
    public function onSuccess(mixed $response): void
    {
        throw new \Exception('Not implemented');
    }
}