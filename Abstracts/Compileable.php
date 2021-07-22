<?php
namespace Mxs\Abstracts;

abstract class Compileable
{
    abstract protected static isCompiled() : bool;
    abstract protected static compile() : bool;
    abstract protected static readCompiled(string $flag);

    public static function load()
    {
        if (self::isCompiled() or self::compile()) {
            return self::readCompiled();
        }

        throw new \Exception( 'failed to compile source '.static::class );
    }

    protected static function makePath( $path ) : string
    {
        return APP_PATH.'/runtime/compile/'.$path;
    }
}

