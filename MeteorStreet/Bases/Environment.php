<?php
namespace Mxs\Bases;

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
        return $this->root( 'config'.$this->_frontds( $path ) );
    }

    final public function runtime_path( $path = '' ) : string {
        return $this->root( 'runtime'.$this->_frontds( $path ) );
    }

    final public function route_path( $path = '' ) : string {
        return $this->root( 'routes'.$this->_frontds( $path ) );
    }

    protected function _frontds( $path ) : string {
        return ( empty( $path ) || $this->_is_ds( $path[ 0 ] ) ? '' : DIRECTORY_SEPARATOR ).$path;
    }

    protected function _is_ds( $sep ) : bool {
        return in_array( $sep, [ '\\', '/' ] );
    }

    protected function init() {
        $this->_root_path = dirname( $_SERVER[ 'DOCUMENT_ROOT' ] ).DIRECTORY_SEPARATOR;
    }

    protected $_root_path;
}

