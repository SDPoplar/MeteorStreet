<?php
namespace Mxs\Base;

class MXS extends Single {
    public function run( string $processCls = \Mxs\Def\Process::class ) {
        echo gettype( $processCls );
    }
}

