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

    final public function run( string $process = \Mxs\Defaults\Process::class ) : void {
        $this->valid() or die( $this->getLastErrorMessage() );
        try {
            $process::run( $this );
        } catch( \Exception $e ) {
            var_dump( $e );
        }
    }

    final public function debug() : bool {
        return $this->_app_debug;
    }

    public function &route() : Core {
        //  checkRoute - return list( $controller, $method, $url_args )
        //  getRequest - merge $url_args
        //  dispatch route - save return data into response
        return $this;
    }

    public function &out( string $fmtClass ) : void {
        echo $fmtClass::format( $this->getResponse()->getData() );
    }

    public function &getRequest() : Request {
        return $this->_request;
    }

    public function &getResponse() : Response {
        return $this->_response;
    }

    protected $_app_debug = false;
    protected $_env;
    protected $_route_manager;

    protected $_request = null;
    protected $_response = null;
}

