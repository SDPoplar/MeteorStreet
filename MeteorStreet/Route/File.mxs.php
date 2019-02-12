<?php
namespace Mxs\Route;

class File extends \Mxs\Abstracts\Route {
    protected function findRule( \Mxs\Base\Request $request ) : \Mxs\Route\RouteRule {
        return \Mxs\Route\RouteRule::UnknownRule();
    }
}

