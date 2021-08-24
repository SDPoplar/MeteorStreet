<?php
namespace Mxs\Bases\Process;

class Http extends Base
{
    public function plan() : void
    {
        $this
            ->request( \Mxs\Bases\Request::class )
            ->dispatch( \Mxs\Routes\File::class )
            ->response( \Mxs\Formats\Json::class );
    }

    public function run() : void
    {
        $request = new \Mxs\Bases\Request();
        $env =& \Mxs\Core::get()->environment;
        $routeMgr = new \Mxs\Routes\Manager($env->routePath(), $env->compilePath('/route'));
        $plan = $routeMgr->findRoute($request->getMethod(), $request->getUrl());
        var_dump($plan);
    }
}

