<?php
namespace Mxs\Modes;

class Http extends Base
{
    public function process(): void
    {
        $request = new \Mxs\Http\Request();
        $route = \Mxs\Frame\Route\Compiled::load($request->method)->search($request->url);
        $response = $route->dispatch($request);
        $this->renderResponse($response);
    }

    protected function renderResponse(\Mxs\Http\Response $response)
    {
        if ($response->status->getGroup() === 3) {
            static::RESPONSE_FORMATTER::redirect($response);
        } else {
            static::RESPONSE_FORMATTER::render($response);
        }
    }
}
