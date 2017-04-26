<?php
namespace Mxs\Base;

class Logger {
    static public function findLogger( &$configer ) {
        $logType = $configer->getItem( 'LOG_TYPE' );
        $loggerName = "\\Mxs\\Logger\\{$logType}Logger";
        return new $loggerName();
    }
}
