<?php
namespace Mxs\Route;

class File extends \Mxs\Abstracts\Route {
    protected function findRule( \Mxs\Base\Request $request ) : \Mxs\Base\RouteRule {
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
            $matched = $this->getItemFromRules( $rules, $request->getRequestMethod(), $matches[ 3 ] );
        } while( false );
        if( isset( $matched ) && $matched->valid() ) {
            return $matched;
        }
        if( !is_readable( $defRouteFile ) ) {
            return \Mxs\Base\RouteRule::UnknownRule();
        }
        $rules = include( $defRouteFile );
        return $this->getItemFromRules( $rules ?: [], $request->getRequestMethod(), $methodPath );
    }
}

