<?php
namespace Mxs\Base;

class Request {
    protected $_content;

    public static function LoadRequest() : Request {
        $request = new Request();
        return $request;
    }

    public function &getContent() {
        return $this->_content;
    }

    public function setContent( $content ) {
        $this->_content = $content;
    }
}

