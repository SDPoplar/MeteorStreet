<?php
namespace Mxs\Bases\Route\Rules;

class Dispatch extends \Mxs\Abstracts\RouteRule
{
    public function execute( \Mxs\Bases\Request $request, \Mxs\Bases\Response &$response ) {
        $controllerIns = $this->createController();
        $methodName = $this->_use_method;
        $requestIns = $this->_request_class ? $request->cast( $this->_request_class ) : $request;
        $execResult = $controllerIns->$methodName( $requestIns->merge( $this->getUrlArgs() ) );
        $response->setData( $execResult );
    }

    public function &allow( int $allowed ) : Dispatch {
        $this->_allowed_method = $allowed;
        return $this;
    }

    public function &method( string $useMethod ) : Dispatch {
        list( $this->_use_controller, $this->_use_method ) = explode( '@', $useMethod );
        $this->_use_controller && $this->_use_method or \Mxs\Exceptions\MxsException::Error( 2 );
        $this->_use_controller = "App\\Controllers\\".$this->_use_controller;
        return $this;
    }

    public function &useRequest( string $requestClass ) : Dispatch {
        $this->_request_class = $requestClass;
        return $this;
    }

    protected function createController() : \Mxs\Abstracts\Controller {
        return new $this->_use_controller();
    }

    protected $_allowed_method = 0;
    protected $_use_controller;
    protected $_use_method;
    protected $_request_class = null;
}

