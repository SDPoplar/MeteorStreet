<?php
namespace Mxs\Abstracts;
use \Mxs\Bases\Route\MatchedRule;

class Route {
    public function match( \Mxs\Bases\Request $request ) : ?MatchedRule {
        foreach( $this->_rules as $rule ) {
            if( $rule->matches( $request, $urlArgs ) ) {
                return new MatchedRule( $rule, $urlArgs );
            }
        }
        return null;
    }

    protected function &appendRule( \Mxs\Abstracts\RouteRule $rule ) : Route {
        array_push( $this->_rules, $rule );
        return $this;
    }

    protected function &mergeRule( array $rules ) : Route {
        foreach( $rules as $rule ) {
            if( is_subclass_of( $rule, \Mxs\Abstracts\RouteRule::class ) ) {
                $this->appendRule( $rule );
            }
        }
        return $this;
    }

    protected $_rules = [];
}

