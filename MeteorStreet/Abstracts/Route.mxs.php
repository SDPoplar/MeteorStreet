<?php
namespace Mxs\Abstracts;
use \Mxs\Route\RouteRule;

abstract class Route {

    abstract protected function findRule( \Mxs\Base\Request $request ) : RouteRule;

    public function &distribute( \Mxs\Base\Request &$request ) : \Mxs\Base\Response {
        $this->init();
        $rule = $this->findRule( $request );
        switch( $rule->getRuleType() ) {
            case RouteRule::RULETYPE_STATUS:
            case RouteRule::RULETYPE_METHOD:
                $controller = $rule->loadController();
                $method = $rule->getMethodName();
                $responseContent = $controller->$method();
                GetMxs()->getResponse()->setContent( $responseContent );
                break;
            case RouteRule::RULETYPE_CONTENT:
                $responseContent = $rule->getContent();
                GetMxs()->getResponse()->setContent( $responseContent );
                break;
            case RouteRule::RULETYPE_UNKNOWN:
                
                break;
        }
        return GetMxs()->getResponse();
    }

    protected function init() {
    }
}

