<?php
namespace Mxs\Bases\Route\Rules;

class Dispatch extends Base
{
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

