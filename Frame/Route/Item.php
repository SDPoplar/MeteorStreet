<?php
namespace Mxs\Frame\Route;

use \Mxs\Exceptions\Develops\{
    InvalidRoute as InvalidRouteException,
    InvalidController as InvalidControllerException
};

/*
use \Mxs\Exceptions\Runtimes\{
    CompiledRouteBroken as CompiledRouteBrokenException
};
*/

class Item
{
    public function __construct(
        protected readonly string $route_id,
        protected readonly string $controller,
        protected readonly string $method,
        protected readonly string $use_request = \Mxs\Frame\Requests\Http::class,
        protected readonly array $route_param_names = [],
    ) {
        /*
        empty($this->route_id) and (new CompiledRouteBrokenException())->occur();
        array_key_exists('controller', $settings) or InvalidRouteException::noControllerSetted($this->route_id)->occur();
        $this->controller = $settings['controller'];
        array_key_exists('method', $settings) or InvalidRouteException::noMethodSetted($this->route_id)->occur();
        $this->method = $settings['method'];
        */
    }

    public function &withRouteParams(array $params): self
    {
        $this->route_params = array_merge(
            $this->route_params,
            array_combine($this->route_param_names, $params)
        );
        return $this;
    }

    public function dispatch(\Mxs\Frame\Requests\BaseInterface $request): \Mxs\Frame\Responses\Http
    {
        $cc = $this->controller;
        $ci = new $cc();
        is_subclass_of($ci, \Mxs\Frame\Controller::class) or (new InvalidControllerException())->occur();
        method_exists($ci, $this->method) or InvalidRouteException::noMethodInController($this->route_id)->occur();
        $method_name = $this->method;
        $request_type = $this->use_request;
        $core_call = \Closure::fromCallable(function(\Mxs\Frame\Requests\BaseInterface $request) use ($ci, $method_name, $request_type) {
            $ret = $ci->$method_name($request->cast($request_type));
            if (is_subclass_of($ret, \Mxs\Frame\Responses\Http::class)) {
                return $ret;
            }
            return new \Mxs\Frame\Responses\Http($ret, empty($ret) ? 204 : 200);
        });
        return $core_call($request);
    }

    protected array $route_params = [];
}
