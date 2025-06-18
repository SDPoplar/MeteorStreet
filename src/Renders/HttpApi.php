<?php
namespace Mxs\Renders;

class HttpApi extends \Mxs\Frame\Render implements \Mxs\Frame\ResponseRenderable
{
    function render($response): string
    {
        return json_encode([]);
    }
}
