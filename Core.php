<?php
namespace Mxs;

use \Mxs\Exceptions\{Frame as FrameErr, Runtime as RuntimeErr};

class Core extends \Mxs\Abstracts\Single
{
    use \Mxs\Traits\LastErrorTrait;

    protected function init()
    {
        $this->_env = \Mxs\Bases\Environment::Get();
        $this->_config = new \Mxs\Bases\Config($this->_env->getConfigPath());
    }

    public function valid() : bool
    {
        return true
            && ( $this->_config !== null )
            && true;
    }

    public function getEnvironment() : Environment
    {
        return $this->_env;
    }

    public function getConfig() : Config
    {
        return $this->_config;
    }

    final public function run( string $process = \Mxs\Defaults\Process::class ) : void
    {
        $this->valid() or die( $this->getLastErrorMessage() );
        //  $lastRet = \Mxs\Requests\Tool::getOriginRequest();
        $steps = $this->parseStepsFromGivenProcess( $process );
        try {
            while (!empty( $steps )) {
                $lastRet = ( array_shift( $steps ) )->run( $lastRet ?? null );
            }
        } catch( \Exception $e ) {
            $lastRet = json_encode( [ 'code' => $e->getCode(), 'message' => $e->getMessage() ] );
        }
        echo $lastRet;
    }

    final public function debug() : bool
    {
        return $this->_config->isDebug();
    }

    public function getRequest() : Request
    {
        return $this->_getRequest();
    }

    protected function &_getRequest() : Request
    {
        if( $this->_request === null ) {
            $this->_request = Request::Create();
        }   //  use $this->_request ??= new Request(); after php7.4 ?
        return $this->_request;
    }

    protected function &_getResponse() : Response
    {
        if( $this->_response === null ) {
            $this->_response = Response::Create();
        }   // use $this->_response ??= new Response(); after php7.4 ?
        return $this->_response;
    }

    private function parseStepsFromGivenProcess( string $processClass ) : array
    {
        $p = new $processClass();
        $p->plan();
        $p->valid() or die( 'Invalid process given' );
        return $p->getSteps();
    }

    protected $_config = null;
    protected $_app_debug = false;
    protected $_env;
    protected $_matched_route;

    protected $_request = null;
    protected $_response = null;
}

