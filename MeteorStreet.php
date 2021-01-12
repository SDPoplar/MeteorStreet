<?php
version_compare( PHP_VERSION, '8.0', '>=' ) || die( 'PHP v8.0 or higher is needed' );

// autoload with composer
$autoloadFile = '../vendor/autoload.php';
is_readable( $autoloadFile ) || die( 'no autoload.php found, run composer update may works' );
require( $autoloadFile );
unset( $autoloadFile );

GetMxs()->run();
/*
error_reporting( E_ALL | E_STRICT );
//  error_reporting( 0 );
set_error_handler( [ &$_mxs_engine, "Error" ], E_ALL | E_STRICT );
register_shutdown_function( [ &$_mxs_engine, "Crash" ] );
$_mxs_engine->run();
 */

