<?php
namespace Mxs\Bases\Route;

class File extends \Mxs\Abstracts\Route {
    public function match( \Mxs\Bases\Request $request ) : ?MatchedRule {
        return parent::match( $request );
    }
}

