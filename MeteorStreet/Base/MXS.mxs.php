<?php
namespace Mxs\Base;

class MXS extends Single {
    public function run( string $processCls = \Mxs\Def\Process::class ) {
        $process = new $processCls();
        if( !is_subclass_of( $process, '\\Mxs\\Base\Process' ) ) {
            throw new Exception( '???' );
        }

        if( !$process->init() || $process->valid() ) {
            throw new Exception( '!!!' );
        }

        $process->run();
    }
}

