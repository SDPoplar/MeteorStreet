<?php
namespace MxsClass\Abstracts;

abstract class SingleAbs {
    static protected $_pointers = [];

    protected function __construct() {
        self::$_pointers[ get_called_class() ] = $this;
    }

    function __destruct() {
        unset( self::$_pointers[ get_called_class() ] );
    }
    
    static public function getInstance() {
        $clsName = get_called_class();
        if( ! array_key_exists( $clsName, self::$_pointers ) ) {
            new $clsName();
        }
        return self::$_pointers[ $clsName ];
    }
}
