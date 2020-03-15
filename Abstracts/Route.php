<?php
namespace Mxs\Abstracts;

class Route {
    public function match( \Mxs\Bases\Request $request ) : ?\Mxs\Bases\Route\MatchedRule {
        foreach( $this->_rules as $rule ) {
            if( $rule->matches( $request ) ) {
                return new MatchedRule( $request );
            }
        }
        return null;
    }

    protected function &appendRule( \Mxs\Bases\Route\Rule $rule ) : Route {
        array_push( $this->_rules, $rule );
        return $this;
    }

    protected function &mergeRule( array $rules ) : Route {
        foreach( $rules as $rule ) {
            if( $rule instanceof \Mxs\Bases\Route\Rule ) {
                $this->appendRule( $rule );
            }
        }
        return $this;
    }

    protected $_rules = [];
}

