<?php
namespace Mxs\Bases;

use \Mxs\Enums\HttpStatus as HS;

class Response {
    public static function Create( string $responseClass = Response::class ) : Response {
        return new $responseClass();
    }

    public function cast( string $childClass ) : Response {
        return ( static::class != $childClass ) ? ( new $childClass() ) : $this;
    }

    public function redirect( $url, $delay = 0 ) {
        $this->_http_status = HS::REDIRECT;
        $this->_redir_url = $url;
        $this->_redir_delay = $delay;
    }

    public function isRedirect() : bool {
        return $this->_http_status == HS::REDIRECT;
    }

    public function isCommon() : bool {
        return $this->_http_status == HS::COMMON;
    }

    public function getData() {
        return $this->_data;
    }

    public function setData( $data ) {
        $this->_data = $data;
    }

    protected function __construct( Response $origin = null ) {
        if( $origin ) {
            $this->_http_status = $origin->_http_status;
            $this->_data = $origin->_data;
            $this->_trace = $origin->_trace;
            $this->_redir_url = $origin->_redir_url;
            $this->_redir_delay = $origin->_redir_delay;
        } else {
        }
    }

    protected $_http_status = HS::COMMON;
    protected $_data = [];
    protected $_trace = [];
    protected $_redir_url = '';
    protected $_redir_delay = 0;
}

