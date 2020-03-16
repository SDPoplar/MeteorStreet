<?php
namespace Mxs\Bases\Route;

class MatchedRule {
    public function execMethod( \Mxs\Bases\Request $request ) {
        return [];
    }

    public function getUrlArgs() : array {
        return $this->_url_args;
    }

    protected $_url_args = [];
}

