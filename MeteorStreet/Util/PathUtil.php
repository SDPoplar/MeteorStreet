<?php
namespace Mxs\Util;

class PathUtil {
    public static function CheckPath( string $path ) : string {
        if( !is_dir( $path ) ) {
            mkdir( $path, 0755, true ) || die( "Failed when create path: {$path}" );
        }
        return $path;
    }
}

