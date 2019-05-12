<?php
namespace Mxs\Util;

class PathUtil {
    public static function CheckPath( string $path ) : string {
        if( !is_dir( $path ) ) {
            mkdir( $path, 644, true );
        }
        return $path;
    }
}

