<?php
version_compare( PHP_VERSION, '7.0', '>=' ) || die( 'PHP v7.0 or higher is needed' );

header( 'Content-type:text/html;charset=utf-8' );
define( 'APP_ROOT', dirname( $_SERVER[ 'DOCUMENT_ROOT' ] ).DIRECTORY_SEPARATOR );
defined( 'SRC_PATH' ) || define( 'SRC_PATH', APP_ROOT.'src'.DIRECTORY_SEPARATOR );
is_dir( SRC_PATH ) || mkdir( SRC_PATH, 644, true )
    || die( 'Invalid src path: '.SRC_PATH );
defined( 'DEBUG_MODE' ) || define( 'DEBUG_MODE', false );

define( 'MXS_PATH', dirname( __FILE__ ).DIRECTORY_SEPARATOR );

// autoload
spl_autoload_register(function( $className ) {
    if( preg_match( "/^Mxs\\\\(\w+)\\\\(\w+)$/", $className, $matches ) ) {
        $namespaceName = $matches[ 1 ];
        $className = $matches[ 2 ];
        require_once( MXS_PATH.$namespaceName.DIRECTORY_SEPARATOR.$className.'.mxs.php' );
    } else {
        require_once( SRC_PATH.$className.'.class.php' );
    }
});

\Mxs\Base\MXS::getInstance()->run();
/*
error_reporting( E_ALL | E_STRICT );
//  error_reporting( 0 );
set_error_handler( [ &$_mxs_engine, "Error" ], E_ALL | E_STRICT );
register_shutdown_function( [ &$_mxs_engine, "Crash" ] );
$_mxs_engine->run();
 */

