<?php
namespace Mxs\Route;

interface Router
{
    /**
     * @throws \Mxs\Exceptions\Develops\CommandNotFound|\Mxs\Exceptions\Runtimes\RouteNotFound
     */
    public function dispatch(\Mxs\Inputs\RootInputInterface $in): Item;
}
