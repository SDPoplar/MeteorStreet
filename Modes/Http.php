<?php
namespace Mxs\Modes;

class Http extends Base
{
    public function process(): void
    {
        $request = new \Mxs\Http\Request();
        $route = (new \Mxs\Http\Routes\Manager(\Mxs\Core::Get()->app_root))
            ->getCompiled($request->method)->search($request->url);
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
