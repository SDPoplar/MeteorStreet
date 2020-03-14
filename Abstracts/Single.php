<?php
namespace Mxs\Abstracts;

abstract class Single
{
    final public function getInstance() : Single {
        $clsName = static::class;
        if( !( self::$_ins[ $clsName ] ?? null ) || !is_subclass_of( self::$_ins[ $clsName ], self::class ) ) {
            ( new $clsName() )->init();
        }
        return self::$_ins[ $clsName ];
    }

    protected function init() {
    }

    final private function __construct() {
        self::$_ins[ static::class ] = $this;
    }

    private static $_ins = [];
}

