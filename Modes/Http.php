<?php
namespace Mxs\Modes;

class Http extends Base
{
    public function process(): void
    {
        $request = new \Mxs\Frame\Requests\Http();
        $route = \Mxs\Frame\Route\Compiled::load($request->method)->search($request->url);
        $response = $route->dispatch($request);
        $this->renderResponse($response);
    }

    protected function renderResponse(\Mxs\Frame\Responses\Http $response)
    {
        header('Status: '.$response->status);
        $resp_content = is_array($response->content) ? json_encode($response->content) : ''.$response->content;
        die($resp_content);
    }
}
