<?php
namespace Mxs\Base;

class Single {
    protected static $_lib = [];

    protected final function __construct() {
        Single::$_lib[ static::class ] = $this;
    }

    public static function GetInstance() {
        $key = static::class;
        if( !( self::$_lib[ $key ] ?? null ) ) {
            new $key();
        }
        return self::$_lib[ $key ];
    }
}

