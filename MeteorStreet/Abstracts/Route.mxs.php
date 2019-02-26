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
                $response = GetMxs()->getResponse()->setCode( $rule->getStatus() );
                break;
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

    protected function parseMethodLimit( $method ) : int {
        if( ( $method === '' ) || ( $method === 'all' ) ) {
            return 0b111111;
        }
        $ret = 0;
        $methods = explode( ',', $method );
        foreach( $methods as $limiter ) {
            switch( strtolower( trim( $limiter ) ) ) {
                case 'get':
                    $ret |= \Mxs\Enum\RequestMethod::GET;
                    break;
                case 'post':
                    $ret |= \Mxs\Enum\RequestMethod::POST;
                    break;
                case 'shell':
                    $ret |= \Mxs\Enum\RequestMethod::SHELL;
                    break;
                /*
                case 'put':
                    $ret |= \Mxs\Enum\RequestMethod::PUT;
                    break;
                case 'delete':
                    $ret |= \Mxs\Enum\RequestMethod::DELETE;
                    */
            }
        }
        return $ret;
    }

    protected function parseRuleMask( string $ruleMask, &$method, &$mask ) : bool {
        $maskParts = explode( ':', $ruleMask );
        if( count( $maskParts ) != 2 ) {
            return false;
        }

        $mask = end( $maskParts );
        $method = $this->parseMethodLimit( $maskParts[ 0 ] );
        return $method != \Mxs\Enum\RequestMethod::UNKNOWN;
    }

    protected function getItemFromRules( array $rules, int $method, string $item ) : RouteRule {
        foreach( $rules as $key => $content ) {
            if( !$this->parseRuleMask( $key, $validMethod, $mask ) ) {
                continue;
            }
            if( ( $mask == $item ) && ( $validMethod & $method ) ) {
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
        if( preg_match( '/^method:([\w\\\\]+)@(\w+)$/', $ruleContent, $matches ) ) {
            return RouteRule::MethodRule( $matches[ 1 ], $matches[ 2 ] );
        }
        return RouteRule::UnknownRule();
    }
}

