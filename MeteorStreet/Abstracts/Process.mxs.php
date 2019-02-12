<?php
namespace Mxs\Abstracts;

abstract class Process {
    const IDENTIFIER_INPUT = 'input';
    const IDENTIFIER_OUTPUT = 'output';
    const IDENTIFIER_ROUTE = 'route';
    const IDENTIFIER_ENCRYPT = 'encrypt';
    const IDENTIFIER_DECRYPT = 'decrypt';

    private $_steps = [];
    private $_identifiers = [];
    private $_cursor = 0;
    private $_instanceMap = [];

    abstract public function init();

    final public function __construct() {
        $reflect = new \ReflectionClass( get_class( $this ) );
        $this->_identifiers = $reflect->getConstants();
    }

    public function valid() : bool {
        return ( $this->_steps[ 0 ][ 'identifier' ] == self::IDENTIFIER_INPUT )
            && ( $this->_steps[ count( $this->_steps ) - 1 ][ 'identifier' ] == self::IDENTIFIER_OUTPUT );
    }

    private function _validCursor() : bool {
        return $this->_cursor < count( $this->_steps );
    }

    public function step() {
        if( !$this->_validCursor() ) {
            return;
        }
        switch( $this->_steps[ $this->_cursor ][ 'identifier' ] ) {
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
            //  throw new Exception();
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
        return $this->registStep( self::IDENTIFIER_INPUT, $className );
    }

    final protected function output( string $className ) : Process {
        return $this->registStep( self::IDENTIFIER_OUTPUT, $className );
    }

    final protected function encrypt( string $className ) : Process {
        return $this->registStep( self::IDENTIFIER_ENCRYPT, $className );
    }

    final protected function decrypt( string $className ) : Process {
        return $this->registStep( self::IDENTIFIER_DECRYPT, $className );
    }

    final protected function route( string $className ) : Process {
        return $this->registStep( self::IDENTIFIER_ROUTE, $className );
    }
}

