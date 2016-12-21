<?php
namespace MxsClass\Base;

class MxsLogger {
    static public function findLogger( &$configer ) {
        spl_autoload_register(function( $className ) {
            $parts = explode( ',', $className );
            include_once( MXS_PATH.'Logger'.DIRECTORY_SEPARATOR.$parts[ count( $parts )-1 ].'Logger.mxs.php' );
        });
        $logType = $configer->getItem( 'LOG_TYPE' );
        $loggerName = "\\MxsClass\\Logger\\{$logType}Logger";
        return new $loggerName();
    }
}
