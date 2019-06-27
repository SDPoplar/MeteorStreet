<?php
namespace Mxs\Util;

class DevUtil
{
    const TPL_PATH = MXS_PATH.'tpl'.DIRECTORY_SEPARATOR;

    public static function copyTplFile( string $needFile ) : bool
    {
        if( empty( $needFile ) ) {
            return false;
        }
        $unixPwd = explode( '/', $needFile );
        $fileName = end( $unixPwd );
        $tplPath = self::TPL_PATH.preg_replace( '/.php$/', '.tpl.php', $needFile );
        array_pop( $unixPwd );
        $unixPwd = implode( DIRECTORY_SEPARATOR, $unixPwd );
        $needPath = SRC_PATH.$unixPwd.DIRECTORY_SEPARATOR;
        return PathUtil::CheckPath( $needPath ) && copy( $tplPath, $needPath.$fileName );
    }
}

