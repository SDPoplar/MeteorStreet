<?php
namespace Mxs\Modes;

readonly class Http extends \Mxs\Frame\AppMode
{
    public function __construct(
        string $root_input_type = \Mxs\Inputs\HttpRequest::class,
        string $render_type = \Mxs\Renders\HttpApi::class,
    ) {
        parent::__construct($root_input_type, $render_type);
    }

    /*
    public function process(): void
    {
        $request = new \Mxs\Http\Request();
        $route = (new \Mxs\Http\Routes\Manager(\Mxs\App::get()->app_root))
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
    */
}
