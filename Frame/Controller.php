<?php
namespace Mxs\Frame;

abstract class Controller
{
    protected function success(\Stringable|string|array $response): \Mxs\Frame\Responses\Http
    {
        return new \Mxs\Frame\Responses\Http($response, empty($response) ? 204 : 200);
    }
}
