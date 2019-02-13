<?php
namespace Mxs\Route;

class File extends \Mxs\Abstracts\Route {
    protected function findRule( \Mxs\Base\Request $request ) : \Mxs\Route\RouteRule {
        $methodPath = $request->getMethodPath();
        $routeFilePath = SRC_PATH.'route'.DIRECTORY_SEPARATOR;
        $defRouteFile = $routeFilePath.'default.php';
        do {
            if( !preg_match( '/^\/([\w\-]+)((\/.*)+)/', $methodPath, $mathes ) ) {
                continue;
            }
            $routeFile = $routeFilePath.$mathes[ 1 ].'.php';
            if( !is_readable( $routeFile )  ) {
                continue;
            }
            $rules = include( $routeFile );
            $matched = $this->getItemFromRules( $rules, $matches[ 3 ] );
        } while( false );
        if( ( ( $matched ?? '' ) == '' ) && is_readable( $defRouteFile ) ) {
            $rules = include( $defRouteFile );
            $matched = $this->getItemFromRules( $rules, $methodPath );
        }
        if( ( $matched ?? '' ) == '' ) {
            return \Mxs\Route\RouteRule::UnknownRule();
        }
    }

    protected function getItemFromRules( array $rules, string $item ) : string {
        return '';
    }
}

