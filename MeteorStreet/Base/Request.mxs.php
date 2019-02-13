<?php
namespace Mxs\Base;

class Request {
    protected $_content;

    protected $_methodPath = '/';
    protected $_requestType = \Mxs\Enum\RequestType::UNKNOWN;
    protected $_requestMethod = \Mxs\Enum\RequestMethod::UNKNOWN;

    public static function LoadRequest() : Request {
        $request = new Request();
        $request->_parseRequestType();
        $request->_parseMethodPath();
        return $request;
    }

    public function isPost() : bool {
        return ( $this->_requestMethod == \Mxs\Enum\RequestMethod::POST );
    }

    public function isCgi() : bool {
        return ( $this->_requestType == \Mxs\Enum\RequestType::GCI );
    }

    public function getMethodPath() {
        return $this->_methodPath;
    }

    public function &getContent() {
        return $this->_content;
    }

    public function setContent( $content ) {
        $this->_content = $content;
    }

    private function _parseRequestType() {
        if( ( $argc ?? 0 ) && array_key_exists( 'SHELL', $_SERVER ) ) {
            $this->_requestType = \Mxs\Enum\RequestType::CGI;
            $this->_requestType = \Mxs\Enum\RequestMethod::SHELL;
            return;
        }

        $this->_requestType = \Mxs\Enum\RequestType::HTTP;
        switch( $_SERVER[ 'METHOD' ] ?? 'UNKNOWN' ) {
            case 'GET':
                $this->_requestMethod = \Mxs\Enum\RequestMethod::GET;
                break;
            case 'POST':
                $this->_requestMethod = \Mxs\Enum\RequestMethod::POST;
                break;
            /*
            case 'PUT':
                $this->_requestMethod = \Mxs\Enum\RequestMethod::PUT;
                break;
            case 'DELETE':
                $this->_requestMethod = \Mxs\Enum\RequestMethod::DELETE;
                break;
            */
        }
    }

    private function _parseMethodPath() {
        if( $this->_requestType == \Mxs\Enum\RequestType::CGI ) {
            $this->_methodPath = $argv[ 1 ] ?? '/';
            return;
        }

        if( $this->_requestType == \Mxs\Enum\RequestType::HTTP ) {
            $this->_methodPath = $_SERVER[ 'REQUEST_URI' ];
            return;
        }
    }
}

