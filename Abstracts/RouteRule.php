<?php
namespace Mxs\Abstracts;

abstract class RouteRule
{
    abstract public function execRule( \Mxs\Bases\Request $request, \Mxs\Bases\Response &$response );

    public function __construct( string $match ) {
        $this->_matched_url = $match;
        $this->_use_regex = preg_match( '/{\w+}/', $match );
    }

    public function matches( \Mxs\Bases\Request $request, ?array &$urlArgs ) : bool {
        $urlArgs = [];
        return true;
    }

    protected $_matched_url;
    protected $_use_regex;
}

