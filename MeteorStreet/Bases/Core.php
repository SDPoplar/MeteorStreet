<?php
namespace Mxs\Bases;

class Core extends \Mxs\Abstracts\Single
{
    use \Mxs\Traits\InitableTrait, \Mxs\Traits\LastErrorTrait;

    protected function init() {
        $this->_app_debug = defined( 'DEBUG_MODE' ) ? DEBUG_MODE : false;
        $this->_env = Environment::GetInstance();
        $this->_route_manager = new \Mxs\Bases\Route\Manager( $this->env()->route_path() );
    }

    public function valid() : bool {
        return true;
    }

    public function env() : Environment {
        return $this->_env;
    }

    final public function run() {
        $this->valid() or die( $this->getLastErrorMessage() );
    }

    final public function debug() : bool {
        return $this->_app_debug;
    }

    protected $_app_debug = false;
    protected $_env;
    protected $_route_manager;
}

