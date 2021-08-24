<?php
namespace Mxs\Route;

use \Mxs\Exceptions\Route\{InvalidDispatchPerformer};
use \Mxs\Route\Plans\{Dispatch, StaticResponse, Redirect};
use \Mxs\Defaults\DefRequest;

class RuleBuilder
{
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    public function patternRule() : bool
    {
        return $this->asPattern;
    }

    public function &middleware(array $mid) : static
    {
        $this->midd = $mid;
        return $this;
    }

    public function &dispatch(string $performer, string $requestType = DefRequest::class) : static
    {
        $parts = explode('@', $performer);
        if (count($parts) != 2) {
            throw new InvalidDispatchPerformer($performer);
        }
        array_push($parts, $requestType);
        $this->plan = array_merge([Dispatch::class], $parts);
        return $this;
    }

    public function &redirect(string $url) : static
    {
        $this->plan = [Redirect::class, $url];
        return $this;
    }

    public function &response(string $type) : static
    {
        $this->plan = [StaticResponse::class, $type];
        return $this;
    }

    public function &setRouteParamKeys(array $keys) : static
    {
        $this->asPattern = true;
        $this->route_params = $keys;
        return $this;
    }

    public function isDefRoute() : bool
    {
        return $this->url == '*';
    }

    public function __toString() : string
    {
        return ($this->isDefRoute() ? '' : "\"{$this->url}\" => ")
            ."[\"midd\" => ".self::arr2str($this->midd).", \"plan\" => ".self::arr2str($this->plan)
            .($this->patternRule() ? ", \"route_params\" => ".self::arr2str($this->route_params) : '')
            .']';
    }

    protected static function arr2str(array $arr) : string
    {
        if (empty($arr)) {
            return '[]';
        }

        return "[\"".implode("\", \"", $arr)."\"]";
    }

    protected string $url;
    protected bool $asPattern = false;

    protected array $route_params = [];
    protected array $plan = [];
    protected array $midd = []; //  middleware
}

