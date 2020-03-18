<?php
namespace Mxs\Routes;

use \Mxs\Enums\HttpMethod as EHttpMethod;

class Rule
{
    public function &get( string $path ) {
        $this->path( $path );
        $this->method( EHttpMethod::GET );
        return $this;
    }

    public function &method( int $method ) {
        $this->_allow_method |= $method;
        return $this;
    }

    public function &path( string $path ) {
        return $this;
    }

    public function match( \Mxs\Http\Request $request ) : bool {
        print_r( $this );
        return true
            && $this->checkMethod( $request->getMethod() )
            && $this->checkPath( $request->getPath(), $request )
            && true;
    }

    public function checkMethod( int $method ) : bool {
        return !!( $this->_allow_method & $method );
    }

    public function checkPath( string $path, \Mxs\Http\Request &$request ) : bool {
        if( !$this->_path_pattern ) {
            return $path == $this->_path;
        }
        if( !preg_match( $this->_path, $path, $matches ) ) {
            return false;
        }

        array_shift( $matches );
        return $request->mergeRouteInput( $matches );
    }

    protected $_path;
    protected $_path_pattern = false;
    protected $_allow_method = 0;
}

