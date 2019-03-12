<?php
namespace Mxs\Def;

class Process extends \Mxs\Abstracts\Process {
    public function init() {
        $this
            ->input( \Mxs\IO\StreamIO::class )
            ->decrypt( \Mxs\Crypt\Json::class )
            ->route( \Mxs\Route\File::class )
            ->encrypt( \Mxs\Crypt\Json::class )
            ->output( \Mxs\IO\StreamIO::class );
    }
}

