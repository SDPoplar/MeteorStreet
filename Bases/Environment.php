<?php
namespace Mxs\Bases;

use \Mxs\Tools\PathFormator as PF;

class Environment extends \Mxs\Abstracts\Single
{
    final public function root( string $path = '' ) : string {
        /*
        empty( $path ) || $this->_is_ds( substr( $path, -1 ) )
            || ( $path = $path.DIRECTORY_SEPARATOR );
         */
        return $this->_root_path.$path;
    }

    final public function getLangPath() : string {
        return $this->root( 'lang' );
    }

    final public function getConfigPath( string $path = '' ) : string {
        return $this->root( 'config'.PF::FrontDirSep( $path ) );
    }

    final public function getRuntimePath( $path = '' ) : string {
        return $this->root( 'runtime'.PF::FrontDirSep( $path ) );
    }

    final public function getRoutePath( $path = '' ) : string {
        return $this->root( 'routes'.PF::FrontDirSep( $path ) );
    }

    public function checkPath( string $path, bool $createIfNotExists = false ) : bool {
        return is_dir( $path ) || ( $createIfNotExists && mkdir( $path, 0755, true ) );
    }

    public function getMxsResourcePath() : string {
        return PF::EndDirSep( $this->_mxs_root.'Resources' );
    }

    public function valid() : bool
    {
        return true
            && !empty( $this->_mxs_root )
            && !empty( $this->_root_path )
            && true;
    }
    
    protected function init() {
        $this->_root_path = PF::EndDirSep( dirname( $_SERVER[ 'DOCUMENT_ROOT' ] ) );
        $this->_mxs_root = PF::EndDirSep( dirname( __DIR__ ) );
    }

    protected $_root_path;
    protected $_mxs_root;
}

