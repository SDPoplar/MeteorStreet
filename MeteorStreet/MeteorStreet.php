<?php
version_compare( PHP_VERSION, '7.0', '>=' ) || die( 'PHP v7.0 or higher is needed' );

header( 'Content-type:text/html;charset=utf-8' );
define( 'APP_ROOT', dirname( $_SERVER[ 'DOCUMENT_ROOT' ] ).DIRECTORY_SEPARATOR );
defined( 'SRC_PATH' ) || define( 'SRC_PATH', APP_ROOT.'src'.DIRECTORY_SEPARATOR );
define( 'MXS_PATH', dirname( __FILE__ ).DIRECTORY_SEPARATOR );

defined( 'DEBUG_MODE' ) || define( 'DEBUG_MODE', false );

// autoload with composer
$autoloadFile = APP_ROOT.'/vendor/autoload.php';
is_readable( $autoloadFile ) || die( 'no autoload.php found, run composer update may works' );
require( $autoloadFile );
unset( $autoloadFile );

\Mxs\Util\PathUtil::CheckPath( SRC_PATH );

function GetMxs() : \Mxs\Base\MXS {
    return \Mxs\Base\MXS::GetInstance();
}

GetMxs()->run();
/*
error_reporting( E_ALL | E_STRICT );
//  error_reporting( 0 );
set_error_handler( [ &$_mxs_engine, "Error" ], E_ALL | E_STRICT );
register_shutdown_function( [ &$_mxs_engine, "Crash" ] );
$_mxs_engine->run();
 */

