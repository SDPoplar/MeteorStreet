<?php
namespace Mxs\Bases\Route;

class Manager extends \Mxs\Abstracts\UseAllFiles
{
    public function &__call( $method, $args ) {
        $rule = new Rule();
        $this->registRouteRule( $rule );
        call_user_func_array( [ $rule, $method ], $args );
        return $rule;
    }

    public function match( \Mxs\Http\Request $request ) : Rule {
        foreach( $this->_rules as $rule ) {
            if( $rule->match( $request ) ) {
                return $rule;
            }
        }
        return null;
    }

    protected function registRouteRule( &$rule ) {
        array_push( $this->_rules, $rule );
    }

    protected function parseFile( string $fileName ) : bool {
        return ( function( &$route ) use ( $fileName ) {
            include( $fileName );
            return true;
        } )( $this );
    }

    protected $_rules = [];
}

