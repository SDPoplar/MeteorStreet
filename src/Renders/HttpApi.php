<?php
namespace Mxs\Renders;

class HttpApi extends \Mxs\Frame\Render
{
    public function onSuccess($response): void
    {
        header('Status: 200');
        echo json_encode(['msg' => 'hello']);
    }
}
