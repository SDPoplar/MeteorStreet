<?php
namespace Mxs\Route;

abstract class RouteRule {
    const RULETYPE_UNKNOWN = 0;
    const RULETYPE_STATUS = 1;
    const RULETYPE_CONTENT = 2;
    const RULETYPE_METHOD = 3;

    protected $_ruleType = self::RULETYPE_UNKNOWN;

    final public function getRuleType() {
        return $this->_ruleType;
    }

    public static function UnknownRule() : UnknownRouteRule {
        return new UnknownRouteRule();
    }
}

class UnknownRouteRule extends RouteRule {
}

class StatusRouteRule extends RouteRule {
    protected $_status;
    public function __construct( int $status = 200 ) {
        $this->_ruleType = self::RULETYPE_STATUS;
        $this->_status = $status;
    }

    public function getStatus() : int {
        return $this->_status;
    }
}

