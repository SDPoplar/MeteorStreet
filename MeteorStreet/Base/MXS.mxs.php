<?php
namespace Mxs\Base;

class MXS extends Single {
    public function run( string $processCls = \Mxs\Def\Process::class ) {
        try {
            $process = new $processCls();
            $process->init();

            if( !$process->valid() ) {
                return;
            }

            do {
                $process->step();
            } while( $process->next() );
        } catch( Exception $e ) {
        }
    }
}

