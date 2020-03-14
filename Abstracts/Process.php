<?php
namespace Mxs\Abstracts;

abstract class Process
{
    abstract public static function run( \Mxs\Bases\Core $mxs ) : void;
}

