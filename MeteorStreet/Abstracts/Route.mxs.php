<?php
namespace Mxs\Abstracts;
use \Mxs\Base\RouteRule;
use \Mxs\Enum\RouteRuleType;

abstract class Route {

    abstract protected function findRule( \Mxs\Base\Request $request ) : RouteRule;

    public function &distribute( \Mxs\Base\Request &$request ) : \Mxs\Base\Response {
        $this->init();
        $rule = $this->findRule( $request );
        switch( $rule->getRuleType() ) {
            case RouteRuleType::STATUS:
            case RouteRuleType::METHOD:
                $controller = $rule->loadController();
                $method = $rule->getMethodName();
                $responseContent = $controller->$method();
                GetMxs()->getResponse()->setContent( $responseContent );
                break;
            case RouteRuleType::CONTENT:
                $responseContent = $rule->getContent();
                GetMxs()->getResponse()->setContent( $responseContent );
                break;
            case RouteRuleType::UNKNOWN:
                
                break;
        }
        return GetMxs()->getResponse();
    }

    protected function init() {
    }

    protected function getItemFromRules( array $rules, string $item ) : RouteRule {
        return RouteRule::UnknownRule();
    }
}

