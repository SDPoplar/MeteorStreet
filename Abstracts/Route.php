<?php
namespace Mxs\Abstracts;
use \Mxs\Bases\Route\MatchedRule;

class Route {
    public function match( \Mxs\Bases\Request $request ) : ?MatchedRule {
        foreach( $this->_rules as $rule ) {
            if( $rule->matches( $request ) ) {
                return new MatchedRule( $request );
            }
        }
        return null;
    }

    protected function &appendRule( \Mxs\Bases\Route\Rules\Base $rule ) : Route {
        array_push( $this->_rules, $rule );
        return $this;
    }

    protected function &mergeRule( array $rules ) : Route {
        foreach( $rules as $rule ) {
            if( is_subclass_of( $rule, \Mxs\Bases\Route\Rules\Base::class ) ) {
                $this->appendRule( $rule );
            }
        }
        return $this;
    }

    protected $_rules = [];
}

