<?php
namespace Mxs\Gate;

interface Middleware
{
    public function handle(\Mxs\Gate\Input $in, \Closure $next): mixed;
}
