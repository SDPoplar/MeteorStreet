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
        $routeMgr = new \Mxs\Route\Manager($mxs->getEnvironment()->routePath(), $mxs->getEnvironment()->compilePath('route'));
        $plan = $routeMgr->findPlan($request->getMethod(), $request->getUrl());
    }
}

