<?php
namespace Mxs\Bases\Route;

class MatchedRule
{
    public function execMethod( \Mxs\Bases\Request $request ) {
        return [];
    }

    public function getUrlArgs() : array {
        return $this->_url_args;
    }

    public function __construct( \Mxs\Abstracts\RouteRule $rule, array $urlArgs ) {
        $this->_url_args = $urlArgs;
    }

    protected $_url_args = [];
}

