<?php
namespace Mxs\Abstracts;

class Route {
    public function match( \Mxs\Bases\Request $request ) : ?RouteRule {
        foreach( $this->_rules as $rule ) {
            if( $rule->matched( $request ) ) {
                return $rule;
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

