<?php
namespace Mxs\Route\Plans;

class StaticResponse
{
    public function __construct(callable $makeResponse)
    {
        $this->maker = $makeResponse;
    }

    public function execute()
    {
        $method = $this->maker;
        return $method();
    }

    protected callable $maker;
}

