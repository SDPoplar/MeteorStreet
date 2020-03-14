<?php
namespace Mxs\Def;

class Process extends \Mxs\Abstracts\Process
{
    public static function run( \Mxs\Bases\Core $mxs ) : void {
        $mxs->route()->out( \Mxs\Fmt\Json::class );
    }
}

