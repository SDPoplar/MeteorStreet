<?php
use MxsClass\Base\MxsException;

class MXS {
    static protected $_me = null;

    protected $_configer = null;
    protected $_router = null;
    protected $_ioer = null;
    protected $_crypter = null;
    protected $_logger = null;


    static public function getInstance() {
        if( ! MXS::$_me ) {
            new MXS();
        }

        return !MXS::$_me;
    }

    public function Crash() {
        $error = error_get_last();
        if( ! $error ) {
            return;
        }

        switch( $error[ 'type' ] ) {
        case E_ERROR:
        default:
            DEBUG_MODE && print_r( $error );
            break;
        }
    }

    public function Error( $errno, $errstr, $errfile, $errline ) {
        die( "[{$errno}]{$errstr} at ({$errline}){$errfile}" );
    }

    public function run() {
        try {
            include( _MXS_SRC_PATH."Controller/Demo.controller.mxs.php" );
            ( new \SRC\Controller\DemoController() )->test();

        } catch( MxsException $e ) {
        }
    }

    protected function __construct() {
        MXS::$_me = $this;
        spl_autoload_register(function( $className ) {
            $parts = explode( '\\', $className );
            $finalName = MXS_PATH.'Base'.DIRECTORY_SEPARATOR.$parts[ count( $parts )-1 ].'.base.mxs.php';
            include_once( $finalName );
        });

        ( $this->_configer = new \MxsClass\Base\MxsConfiger() )
            || die( 'Load config failed' );

        ( $this->_logger = \MxsClass\Base\MxsLogger::findLogger( $this->_configer ) )
            || die( 'Load logger failed' );

        /*
        ( $this->_crypter = \MxsClass\Base\MxsCrypter::getInstance( $this->_configer, $this->_logger ) )
            || die( 'Load crypter failed' );
         */
        /*
        ( $this->_ioer = \MxsClass\Base\MxsIoer::getInstance( $this->_configer, $this->_logger ) )
            || die( 'Load ioer failed' );
         */
        ( $this->_router = \MxsClass\Base\MxsRouter::getInstance( $this->_configer, $this->_logger ) )
            || die( 'Load router failed' );
    }

    /*
    protected function getConfig( $item, $defval = null ) {
        return $this->_configer ? $this->_configer->getItem( $item, $defval ) : $defval;
    }
     */
}

