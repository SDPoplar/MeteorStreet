<?php
namespace Mxs\Base;

class MXS extends Single {
    protected $_request = null;
    protected $_response = null;

    public function run( string $processCls = \Mxs\Def\Process::class ) {
        try {
            $process = new $processCls();
            if( !is_subclass_of( $process, '\Mxs\Abstracts\Process' ) ) {
                throw new \Exception( '???' );
            }

            $process->init();
            if( !$process->valid() ) {
                return;
            }

            $this->_request = \Mxs\Base\Request::LoadRequest();
            do {
                $process->step();
            } while( $process->next() );
        } catch( Exception $e ) {
        }
    }

    public function &getRequest() : \Mxs\Base\Request {
        return $this->_request;
    }

    public function &getResponse() : \Mxs\Base\Response {
        if( $this->_response === null ) {
            $this->_response = new \Mxs\Base\Response();
        }
        return $this->_response;
    }

    public function setResonse( \Mxs\Base\Response &$response ) {
        $this->_response = $response;
    }
}

