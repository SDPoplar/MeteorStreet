<?php
namespace Mxs\Base;
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

        return MXS::$_me;
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
            ( new \Controller\DemoController() )->test();

        } catch( MxsException $e ) {
        }
    }

    protected function __construct() {
        MXS::$_me = $this;

        ( $this->_configer = new \Mxs\Base\Configer() )
            || die( 'Load config failed' );

        ( $this->_logger = \Mxs\Base\Logger::findLogger( $this->_configer ) )
            || die( 'Load logger failed' );

        /*
        ( $this->_crypter = \MxsClass\Base\MxsCrypter::getInstance( $this->_configer, $this->_logger ) )
            || die( 'Load crypter failed' );
         */
        /*
        ( $this->_ioer = \MxsClass\Base\MxsIoer::getInstance( $this->_configer, $this->_logger ) )
            || die( 'Load ioer failed' );
         */
        ( $this->_router = new \Mxs\Base\Router( $this->_configer, $this->_logger ) )
            || die( 'Load router failed' );
    }

    /*
    protected function getConfig( $item, $defval = null ) {
        return $this->_configer ? $this->_configer->getItem( $item, $defval ) : $defval;
    }
     */
}

