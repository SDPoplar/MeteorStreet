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

    public function &despatch() : Core {
        $this->getResponse()->setData( $this->_matched_route
            ->exec( $this->getRequest()->merge( $this->_matched_route->getUrlArgs() ) )
        );
        return $this;
    }

    public function &request( int $inputLimit = -1 ) : Core {
        $this->getRequest()->init( $this->_matched_route->getHttpMethod(), $inputLimit );
        return $this;
    }

    public function response( string $fmtClass ) : void {
        echo $fmtClass::format( $this->getResponse()->getData() );
    }

    protected function &getRequest() : Request {
        if( $this->_request === null ) {
            $this->_request = new Request();
        }   //  use $this->_request ??= new Request(); after php7.4 ?
        return $this->_request;
    }

    protected function &getResponse() : Response {
        if( $this->_response === null ) {
            $this->_response = new Response();
        }   // use $this->_response ??= new Response(); after php7.4 ?
        return $this->_response;
    }

    protected $_app_debug = false;
    protected $_env;
    protected $_route_manager;
    protected $_matched_route;

    protected $_request = null;
    protected $_response = null;
}

