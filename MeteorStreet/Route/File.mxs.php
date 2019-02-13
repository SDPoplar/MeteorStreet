<?php
namespace Mxs\Route;

class File extends \Mxs\Abstracts\Route {
    protected function findRule( \Mxs\Base\Request $request ) : \Mxs\Route\RouteRule {
        $methodPath = $request->getMethodPath();
        $routeFilePath = SRC_PATH.'route'.DIRECTORY_SEPARATOR;
        preg_match( '/^\/([\w\-]+)((\/.*)+)/', $methodPath, $mathes );
        /*
        TODO: find rule value from different file
        if( $this->getItemFromFile( $routeFilePath.( $mathes[ 1 ] ?? 'default' ).'.php', $met;
        if( file_exists( $fileName ) ) {
            $routeFile = $fileName
        }
        $methodPath = $mathes[ 3 ] ?? $methodPath;
        */
        return \Mxs\Route\RouteRule::UnknownRule();
    }

    protected function getItemFromFile( string $fileName, string $item, string &$value ) : bool {
        return false;
    }
}

