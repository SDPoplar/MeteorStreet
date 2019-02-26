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
                throw new \Mxs\Error\FrameError( \Mxs\Enum\FrameErrorCode::INVALID_ROUTE );
                break;
        }
        return GetMxs()->getResponse();
    }

    protected function init() {
    }

    protected function getItemFromRules( array $rules, string $item ) : RouteRule {
        foreach( $rules as $key => $content ) {
            if( $key == $item ) {
                $ruleContent = $content;
                break;
            }
        }
        if( ( $ruleContent ?? '' ) == '' ) {
            return RouteRule::UnknownRule();
        }
        if( preg_match( '/^status:(\d+)$/', $ruleContent, $matches ) ) {
            return RouteRule::StatusRule( $matches[ 1 ] );
        }
        if( preg_match( '/^content:(.+)$/', $ruleContent, $matches ) ) {
            return RouteRule::ContentRule( $matches[ 1 ] );
        }
        if( preg_match( '/^method:([\w\\]+)@(\w+)$/', $ruleContent, $matches ) ) {
            return RouteRule::MethodRule( $matches[ 1 ], $matches[ 2 ] );
        }
        return RouteRule::UnknownRule();
    }
}

