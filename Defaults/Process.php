<?php
namespace Mxs\Defaults;

class Process extends \Mxs\Abstracts\Process
{
    public static function run( \Mxs\Bases\Core $mxs ) : void {
        $mxs->route()->request()->dispatch()->response( \Mxs\Formats\Json::class );
    }
}

