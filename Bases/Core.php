<?php
namespace Mxs\Bases;

class Core extends \Mxs\Abstracts\Single
{
    use \Mxs\Traits\InitableTrait, \Mxs\Traits\LastErrorTrait;

    protected function init() {
        $this->_env = Environment::GetInstance();
        $this->_config = new Config( $this->_env->getConfigPath() );
    }

    public function valid() : bool {
        return true
            && ( $this->_config !== null )
            && true;
    }

    public function getEnvironment() : Environment {
        return $this->_env;
    }

    public function getConfig() : Config {
        return $this->_config;
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
        return $this->_config->isDebug();
    }

    public function &route( string $routeClass = \Mxs\Bases\Route\File::class ) : Core {
        $this->_matched_route = ( new $routeClass( $this ) )->match( $this->getRequest() );
        //  checkRoute - return list( $controller, $method, $url_args )
        //  getRequest - merge $url_args
        //  dispatch route - save return data into response
        return $this;
    }

    public function &despatch() : Core {
        $this->getResponse()->setData( $this->_matched_route
            ->execMethod( $this->getRequest()->merge( $this->_matched_route->getUrlArgs() ) )
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

    protected $_config = null;
    protected $_app_debug = false;
    protected $_env;
    protected $_matched_route;

    protected $_request = null;
    protected $_response = null;
}

