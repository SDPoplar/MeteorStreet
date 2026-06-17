<?php
namespace Mxs\Commands;

class Cache
{
    public function route()
    {
        app()->router->cache();
    }
}