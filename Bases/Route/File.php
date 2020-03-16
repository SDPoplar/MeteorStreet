<?php
namespace Mxs\Bases\Route;

class File extends \Mxs\Abstracts\Route
{
    public function match( \Mxs\Bases\Request $request ) : ?MatchedRule {
        $mgr = new class ( GetMxs()->getEnvironment()->getRoutePath() )
            extends \Mxs\Abstracts\UseAllFiles {
            use \Mxs\Traits\MakeRouteRuleTrait;

            public function getRules() : array {
                return $this->_rules;
            }

            protected function parseFile( string $fileName ) : bool {
                return ( function( &$route ) use ( $fileName ) {
                    include( $fileName );
                    return true;
                } )( $this );
            }

            protected $_rules = [];
            protected $_router;
        
        };
        $this->mergeRule( $mgr->getRules() );
        return parent::match( $request );
    }
}

