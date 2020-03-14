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

    final public function config_path( string $path = '' ) : string {
        return $this->root( 'config'.PF::FrontDirSep( $path ) );
    }

    final public function runtime_path( $path = '' ) : string {
        return $this->root( 'runtime'.PF::FrontDirSep( $path ) );
    }

    final public function route_path( $path = '' ) : string {
        return $this->root( 'routes'.PF::FrontDirSep( $path ) );
    }

    public function checkPath( $path ) : bool {
        return is_dir( $path ) || ( GetMxs()->debug() && mkdir( $path, 0755, true ) );
    }
    
    protected function init() {
        $this->_root_path = PF::EndDirSep( dirname( $_SERVER[ 'DOCUMENT_ROOT' ] ) );
    }

    protected $_root_path;
}

