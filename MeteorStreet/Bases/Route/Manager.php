<?php
namespace Mxs\Bases\Route;

class Manager extends \Mxs\Abstracts\UseAllFiles
{
    protected function parseFile( string $fileName ) : bool {
        return ( function( &$route ) use ( $fileName ) {
            include( $fileName );
        } )( $this );
    }
}

