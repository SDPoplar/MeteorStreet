<?php
namespace Mxs\Bases\Route\Rules;

class Dispatch extends \Mxs\Abstracts\RouteRule
{
    public function execRule( \Mxs\Bases\Request $request, \Mxs\Bases\Response &$response ) {
        $execResult = ( new $this->_use_controller() )
            ->$this->_use_method( $request );
        $response->setData( $execResult );
    }

    public function &allow( int $allowed ) : Dispatch {
        $this->_allowed_method = $allowed;
        return $this;
    }

    public function &method( string $useMethod ) : Dispatch {
        list( $this->_use_controller, $this->_use_method ) = explode( '@', $useMethod );
        $this->_use_controller && $this->_use_method or \Mxs\Exceptions\MxsException::Error( 2 );
        return $this;
    }

    protected $_allowed_method = 0;
    protected $_use_controller;
    protected $_use_method;
}

