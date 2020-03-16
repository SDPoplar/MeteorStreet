<?php
namespace Mxs\Enums;

class AllowRequestMethod extends HttpMethod
{
    const SHELL         = 1024; //  0x10000000000

    public static function IsMethodAllowed( int $allow, int $method ) : bool {
        return $allow & $method;
    }

    public static function All( int $except = 0 ) {
        $all = ( new \ReflectionClass( static::class ) )->getConstants();
        $ret = 0;
        foreach( $all as $item ) {
            $ret |= $item;
        }
        return $ret ^ $except;
    }
}

