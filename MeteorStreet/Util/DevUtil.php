<?php
namespace Mxs\Util;

class DevUtil
{
    const TPL_PATH = MXS_PATH.'tpl'.DIRECTORY_SEPARATOR;

    public static function copyTplFile( string $needFile ) : bool
    {
        $unixPwd = explode( '/', $needFile );
        $fileName = end( $unixPwd );
        $tplPath = preg_replace( '/.php$/', '.tpl.php', $needFile );
        $unixPwd = implode( DIRECTORY_SEPARATOR, array_pop( $unixPwd ) );
        $needPath = SRC_PATH.$unixPwd.DIRECTORY_SEPARATOR;
        return PathUtil::CheckPath( $needPath ) && copy( $tplPath, $needPath.$fileName );
    }
}

