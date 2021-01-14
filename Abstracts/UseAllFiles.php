<?php
namespace Mxs\Abstracts;

abstract class UseAllFiles
{
    abstract protected function parseFile( string $fileName ) : bool;

    public function __construct( $basePath ) {
        $this->_base_path = \SeaDrip\Tools\PathFormator::EndDirSep( $basePath );
        $this->createDefaultFiles() && $this->loadFiles()
            or die( 'Cannot load files in '.$basePath );
    }

    protected function createDefaultFiles() : bool {
        return true;
    }

    protected function loadFiles() : bool {
        foreach( scandir( $this->_base_path ) ?: [] as $fi ) {
            if( ( strtolower( substr( $fi, -4 ) ) == '.php' )
                && !$this->parseFile( $this->_base_path.$fi ) ) {
                return false;
            }
        }
        return true;
    }

    protected $_base_path;
}

