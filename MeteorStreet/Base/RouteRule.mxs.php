<?php
namespace Mxs\Base;
use Mxs\Enum\RouteRuleType as RRT;

abstract class RouteRule {

    protected $_ruleType = RRT::UNKNOWN;

    final public function getRuleType() {
        return $this->_ruleType;
    }

    public static function UnknownRule() : UnknownRouteRule {
        return new UnknownRouteRule();
    }

    public static function MethodRule( $controllerName, $methodName ) {
        return new MethodRouteRule( $controllerName, $methodName );
    }

    abstract public function valid() : bool;
}

class UnknownRouteRule extends RouteRule {
    public function valid() : bool {
        return false;
    }
}

class StatusRouteRule extends RouteRule {
    protected $_status;

    public function __construct( int $status = 200 ) {
        $this->_ruleType = RRT::STATUS;
        $this->_status = $status;
    }

    public function getStatus() : int {
        return $this->_status;
    }

    public function valid() : bool {
        return true;
    }
}

class MethodRouteRule extends RouteRule {
    protected $_controllerName = '';
    protected $_methodName = '';

    public function __construct( string $controllerName, string $methodName ) {
        $this->_ruleType = RRT::METHOD;
        $this->_controllerName = $controllerName;
        $this->_methodName = $methodName;

        print_r( $this );
    }

    public function createController() : \Mxs\Abstracts\Controller {
        return new $this->_controllerName();
    }

    public function valid() : bool {
        return ( $this->_controllerName != '' ) && ( $this->_methodName != '' );
    }
}

