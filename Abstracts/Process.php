<?php
namespace Mxs\Bases;

abstract class Process
{
    public abstract function run( \Mxs\Base\Core $mxs ) : void;
}

