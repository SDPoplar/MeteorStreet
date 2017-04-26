<?php
version_compare( PHP_VERSION, '5.4', '>=' ) || die( 'Higher version PHP is needed' );

header( 'Content-type:text/html;charset=utf-8' );
define( '_MXS_BASE_PATH', dirname( $_SERVER[ 'SCRIPT_FILENAME' ] ).'/' );
defined( 'SRC_PATH' ) || define( 'SRC_PATH', 'src/' );
define( '_MXS_SRC_PATH', _MXS_BASE_PATH.SRC_PATH );
is_dir( _MXS_SRC_PATH ) || mkdir( _MXS_SRC_PATH, 644, true )
    || die( 'Invalid src path: '._MXS_SRC_PATH );
defined( 'DEBUG_MODE' ) || define( 'DEBUG_MODE', false );

define( 'MXS_PATH', dirname( __FILE__ ).DIRECTORY_SEPARATOR );

// include engine classes
spl_autoload_register(function( $className ) {
    if( preg_match( "/^Mxs\\\\(\w+)\\\\(\w+)$/", $className, $matches ) ) {
        $namespaceName = $matches[ 1 ];
        $className = $matches[ 2 ];
        require_once( MXS_PATH.$namespaceName.DIRECTORY_SEPARATOR
            .$className.'.'.strtolower( $namespaceName ).'.mxs.php'
        );
    }
});

//  include app classes
spl_autoload_register(function( $className ) {
    require_once( _MXS_SRC_PATH.$className.'.class.php' );
});
\Mxs\Base\MXS::getInstance()->run();
/*
error_reporting( E_ALL | E_STRICT );
//  error_reporting( 0 );
set_error_handler( [ &$_mxs_engine, "Error" ], E_ALL | E_STRICT );
register_shutdown_function( [ &$_mxs_engine, "Crash" ] );
$_mxs_engine->run();
 */

