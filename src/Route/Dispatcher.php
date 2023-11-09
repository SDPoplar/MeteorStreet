<?php
namespace Mxs\Route;

interface Dispatcher
{
    /**
     * @throws \Mxs\Exceptions\Develops\CommandNotFound|\Mxs\Exceptions\Runtimes\RouteNotFound
     */
    public function dispatch(\Mxs\Inputs\RootInputInterface $in): Item;
}
