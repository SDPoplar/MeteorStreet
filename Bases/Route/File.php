<?php
namespace Mxs\Bases\Route;

class File extends \Mxs\Abstracts\Route
{
    public function match( \Mxs\Bases\Request $request ) : ?\Mxs\Abstracts\RouteRule {
        $mgr = new class ( GetMxs()->getEnvironment()->getRoutePath() )
            extends \Mxs\Abstracts\UseAllFiles {
            use \Mxs\Traits\MakeRouteRuleTrait;

            protected function parseFile( string $fileName ) : bool {
                return ( function( &$route ) use ( $fileName ) {
                    include( $fileName );
                    return true;
                } )( $this );
            }
        
        };
        $this->mergeRule( $mgr->getRules() );
        return parent::match( $request );
    }
}

