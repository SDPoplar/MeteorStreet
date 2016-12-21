<?php
namespace MxsClass\Base;

class MxsRouter {
    static public function getInstance() {
        return new MxsRouter();
    }

    protected function __construct() {}
}
