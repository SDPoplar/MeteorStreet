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

