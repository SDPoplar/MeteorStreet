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

use \Mxs\Frame\Requests\BaseInterface as IBaseRequest;

class Item
{
    public function __construct(
        protected readonly string $route_id,
        protected readonly string $controller,
        protected readonly string $method,
        protected readonly string $use_request = \Mxs\Frame\Requests\Http::class,
        protected readonly array $route_param_names = [],
        protected readonly array $middlewares = [],
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

    public function dispatch(IBaseRequest $request): \Mxs\Frame\Responses\Http
    {
        $cc = $this->controller;
        $ci = new $cc();
        is_subclass_of($ci, \Mxs\Frame\Controller::class) or (new InvalidControllerException())->occur();
        $method_name = $this->method;
        method_exists($ci, $method_name) or InvalidRouteException::noMethodInController($this->route_id)->occur();
        $real_worker = $ci->$method_name(...);
        $request_type = $this->use_request;
        $core_call = \Closure::fromCallable(function(IBaseRequest $request) use ($real_worker, $request_type) {
            $ret = $real_worker($request->cast($request_type));
            if (is_subclass_of($ret, \Mxs\Frame\Responses\Http::class)) {
                return $ret;
            }
            return new \Mxs\Frame\Responses\Http(empty($ret) ? 204 : 200, $ret);
        });
        $worker_with_middlewares = $this->packMiddlewares($core_call);
        return $worker_with_middlewares($request);
    }

    protected function packMiddlewares(\Closure $worker): \Closure
    {
        $all_middleware = array_reverse($this->middlewares);
        $next = $worker;
        while($m = array_shift($all_middleware))
        {
            $next = function(IBaseRequest $request) use ($m, $next): \Mxs\Frame\Responses\Http {
                return (new $m())->handle($request, $next);
            };
        }
        return $next;
    }

    protected array $route_params = [];
}
