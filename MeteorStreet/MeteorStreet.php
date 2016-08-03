<?php
version_compare( PHP_VERSION, '5.4', '>=' ) || die( 'Higher version PHP is needed' );

define( '_MXS_BASE_PATH', dirname( $_SERVER[ 'SCRIPT_FILENAME' ] ).'/' );
defined( 'SRC_PATH' ) || define( 'SRC_PATH', 'src/' );
define( '_MXS_SRC_PATH', _MXS_BASE_PATH.SRC_PATH );
is_dir( _MXS_SRC_PATH ) || mkdir( _MXS_SRC_PATH ) || die( 'Invalid src path: '._MXS_SRC_PATH );
defined( 'DEBUG_MODE' ) || define( 'DEBUG_MODE', false );

define( 'MXS_PATH', dirname( __FILE__ ).DIRECTORY_SEPARATOR );
// include engine base classes
/*
$mxs_base = dir( MXS_PATH.'Base' );
$baseFileExt = '.base.mxs.php';
while( ( $fileName = $mxs_base->read() ) != false ) {
    ( strstr( strtolower( $fileName ), $baseFileExt ) == $baseFileExt )
        && include_once( MXS_PATH.'Base'.DIRECTORY_SEPARATOR.$fileName );
}
 */
require_once( MXS_PATH.'Load'.DIRECTORY_SEPARATOR.'loader.load.mxs.php' );
( new MXS() )->run();

