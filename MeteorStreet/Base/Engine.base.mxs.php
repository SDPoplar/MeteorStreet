<?php
class MXS {
    protected $_configer = null;
    protected $_router = null;
    protected $_ioer = null;
    protected $_crypter = null;
    protected $_logger = null;

    public function __construct() {
        $this->_configer = new \MxsClass\Base\MxsConfiger();
        $this->_crypter = \MxsClass\Base\MxsCrypter::getInstance();
        $this->_router = \MxsClass\Base\MxsRouter::getInstance(); 
    }
    public function run() {
        echo "~~~";
    }

    /*
    protected function getConfig( $item, $defval = null ) {
        return $this->_configer ? $this->_configer->getItem( $item, $defval ) : $defval;
    }
     */
}
