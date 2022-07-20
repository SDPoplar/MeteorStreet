<?php
namespace Mxs\Abstracts;

abstract class Controller
{
    public function __construct() {
        $this->init();
    }

    protected function init() : void {
    }
}

