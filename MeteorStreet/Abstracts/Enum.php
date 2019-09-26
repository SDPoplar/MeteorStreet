<?php
namespace Mxs\Abstracts;

abstract class Enum
{
    public static function has( $value = null ) : bool {
        return in_array( $value, self::values() );
    }

    public static function values() : array {
        $ins = new \ReflectionClass( static::class );
        return array_values( $ins->getConstants() );
    }
}

