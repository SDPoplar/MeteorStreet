<?php
namespace Mxs\Abstracts;
use Mxs\Enum\ProcessIdentifier as EPI;

abstract class Process {
    private $_steps = [];
    private $_identifiers = [];
    private $_cursor = 0;
    private $_instanceMap = [];

    abstract public function init();

    final public function __construct() {
        $reflect = new \ReflectionClass( EPI::class );
        $this->_identifiers = $reflect->getConstants();
    }

    public function valid() : bool {
        return ( $this->_steps[ 0 ][ 'identifier' ] == EPI::INPUT )
            && ( $this->_steps[ count( $this->_steps ) - 1 ][ 'identifier' ] == EPI::OUTPUT );
    }

    private function _validCursor() : bool {
        return $this->_cursor < count( $this->_steps );
    }

    public function step() {
        if( !$this->_validCursor() ) {
            return;
        }
        $stepInstance = $this->_steps[ $this->_cursor ][ 'instance' ];
        switch( $this->_steps[ $this->_cursor ][ 'identifier' ] ) {
            case EPI::INPUT:
                $stepInstance->input( GetMxs()->getRequest() );
                break;
            case EPI::AUTH:
                break;
            case EPI::ENCRYPT:
                break;
            case EPI::DECRYPT:
                break;
            case EPI::ROUTE:
                GetMxs()->setResonse( $stepInstance->distribute( GetMxs()->getRequest() ) );
                break;
            case EPI::OUTPUT:
                $stepInstance->output( GetMxs()->getResponse() );
                break;
        }
    }

    public function next() : bool {
        if( !$this->_validCursor() ) {
            return false;
        }
        $this->_cursor++;
        return true;
    }

    final protected function registStep( string $identifier, string $className ) : Process {
        if( !in_array( $identifier, $this->_identifiers ) ) {
            //  throw new Exception( 'Unknown step' );
        }

        if( array_key_exists( $className, $this->_instanceMap ) ) {
            $stepInstance = $this->_instanceMap[ $className ];
        } else {
            $stepInstance = new $className();
            $this->_instanceMap[ $className ] = $stepInstance;
        }
        
        array_push( $this->_steps, [ 'identifier' => $identifier, 'instance' => $stepInstance ] );
        return $this;
    }

    final protected function input( string $className ) : Process {
        return $this->registStep( EPI::INPUT, $className );
    }

    final protected function output( string $className ) : Process {
        return $this->registStep( EPI::OUTPUT, $className );
    }

    final protected function encrypt( string $className ) : Process {
        return $this->registStep( EPI::ENCRYPT, $className );
    }

    final protected function decrypt( string $className ) : Process {
        return $this->registStep( EPI::DECRYPT, $className );
    }

    final protected function route( string $className ) : Process {
        return $this->registStep( EPI::ROUTE, $className );
    }

    final protected function auth( string $className ) : Process {
        return $this->registStep( EPI::AUTH, $className );
    }
}

