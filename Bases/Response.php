<?php
namespace Mxs\Bases;

use \Mxs\Enums\HttpStatus as HS;

class Response {
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

    protected $_http_status = HS::COMMON;
    protected $_data = [];
    protected $_trace = [];
    protected $_redir_url = '';
    protected $_redir_delay = 0;
}

