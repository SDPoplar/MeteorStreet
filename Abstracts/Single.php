<?php
namespace Mxs\Abstracts;

abstract class Single
{
    use \Mxs\Traits\InitableTrait;

    final public static function getInstance() : static
    {
        $clsName = static::class;
        if( !( self::$_ins[ $clsName ] ?? null ) || !is_subclass_of( self::$_ins[ $clsName ], self::class ) ) {
            ( new $clsName() )->init();
        }
        return self::$_ins[ $clsName ];
    }

    final private function __construct()
    {
        self::$_ins[ static::class ] = $this;
    }

    private static $_ins = [];
}

