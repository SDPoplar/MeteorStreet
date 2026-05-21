<?php
namespace Mxs\Routes;

interface MiddlewareInterface
{
    public function handle(\Mxs\Inputs\RootInput $in, \Closure $next): mixed;
}
