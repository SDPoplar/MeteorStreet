<?php
namespace MxsClass\Base;

class MxsCrypter {
    static public function getInstance() {
        return new MxsCrypter();
    }

    protected function __construct() {
    }
}
