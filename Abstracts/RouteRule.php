<?php
namespace Mxs\Abstracts;

abstract class RouteRule
{
    abstract public function execute( \Mxs\Bases\Request $request, \Mxs\Bases\Response &$response );

    public function __construct( string $match ) {
        $this->_matched_url = $match;
        $this->_use_regex = preg_match( '/{\w+}/', $match );
    }

    public function matched( \Mxs\Bases\Request $request ) : bool {
        return $this->_use_regex
            ? preg_match( "/".addslashes( $this->_matched_url )."/", $request->getUrl(), $this->_url_args )
            : ( $request->getUrl() == $this->_matched_url );
    }

    protected function getUrlArgs() : array {
        return $this->_url_args;
    }

    protected $_matched_url;
    protected $_use_regex;
    protected $_url_args = [];
}

