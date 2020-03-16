<?php
namespace Mxs\Bases\Route\Rules;

class Base
{
    public function __construct( string $match ) {
        $this->_matched_url = $match;
        $this->_use_regex = preg_match( '/{\w+}/', $match );
    }

    public function matches( \Mxs\Bases\Request $request ) : bool {
        return true;
    }

    protected $_matched_url;
    protected $_use_regex;
}

