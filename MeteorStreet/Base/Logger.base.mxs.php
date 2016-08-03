<?php
namespace MxsClass\Base;

class MxsLogger {
    static public function getInstance( &$configer ) {
        $logType = $configer->getItem( 'LOG_TYPE' );
        $loggerFile = MXS_PATH.'Logger/'.$logType.'Logger.mxs.php';
        if( ! file_exists( $loggerFile ) ) {
            return null;
        }
        require_once( $loggerFile );
        $loggerName = "\\MxsClass\\Logger\\{$logType}Logger";
        return $loggerName::getInstance();
    }
}
