<?php
namespace Mxs\Route;

use \Mxs\Exceptions\Route\{EmptyUrl};

class RuleManager
{
    public function &__call($method, $args) : RuleBuilder
    {
        if (in_array($method, ['get', 'post', 'put', 'patch', 'options', 'delete'])) {
            return $this->createBuilder($method, ...$args);
        }
        throw new \Exception('call to undefined method'.$method);
    }

    public function getAll() : array
    {
        return $this->all;
    }

    protected function &createBuilder(string $method, string $url) : RuleBuilder
    {
        empty($url) && self::hasInvalidRule(EmptyUrl::class);
        $route_params = [];
        $final_url = preg_replace_callback('/\{(\w+)\}/', function($found) use (&$route_params) {
            $route_params[] = $found[1];
            return '(\w+)';
        }, $url);
        $ret = new RuleBuilder($final_url ?: $url);
        if (!empty($route_params)) {
            $ret->setRouteParamKeys($route_params);
        }
        if (!array_key_exists($method, $this->all)) {
            $this->all[ $method ] = [];
        }
        $this->all[ $method ][] =& $ret;
        return $ret;
    }

    protected static function hasInvalidRule(string $exceptionType) : bool
    {
        throw new $exceptionType();
        return true;
    }

    protected array $all = [];
}

