<?php
use MxsClass\Base\MxsException;

class MXS extends \MxsClass\Abstracts\SingleAbs {
    protected $_configer = null;
    protected $_router = null;
    protected $_ioer = null;
    protected $_crypter = null;
    protected $_logger = null;

    protected function __construct() {
        parent::__construct();
        ( $this->_configer = new \MxsClass\Base\MxsConfiger() )
            || die( 'Load config failed' );

        ( $this->_logger = \MxsClass\Base\MxsLogger::getInstance( $this->_configer ) )
            || die( 'Load logger failed' );
        ( $this->_crypter = \MxsClass\Base\MxsCrypter::getInstance( $this->_configer, $this->_logger ) )
            || die( 'Load crypter failed' );
        /*
        ( $this->_ioer = \MxsClass\Base\MxsIoer::getInstance( $this->_configer, $this->_logger ) )
            || die( 'Load ioer failed' );
         */
        ( $this->_router = \MxsClass\Base\MxsRouter::getInstance( $this->_configer, $this->_logger ) )
            || die( 'Load router failed' );
    }
    public function run() {
        try {
        } catch( MxsException $e ) {
        }
    }

    /*
    protected function getConfig( $item, $defval = null ) {
        return $this->_configer ? $this->_configer->getItem( $item, $defval ) : $defval;
    }
     */
}

