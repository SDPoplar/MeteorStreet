<?php
namespace Mxs\Traits;

trait LastErrorTrait
{
    final protected function setLastError( int $code, string $msg )
    {
        $this->_lastErrorCode = $code;
        $this->_lastErrorMsg = $msg;
    }

    final public function getLastError() : int
    {
        return $this->_lastErrorCode;
    }

    final public function getLastErrorMessage() : string
    {
        return $this->_lastErrorMsg;
    }

    protected $_lastErrorCode = 0;
    protected $_lastErrorMsg = '';
}

