<?php
namespace Mxs\Base;

class Process {
    protected $_process = [];

    abstract public function init() : bool;

    public function valid() : bool {
        return false;
    }

    public function run() {
        
    }
}

