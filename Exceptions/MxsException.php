<?php
namespace Mxs\Exceptions;

class MxsException extends \Exception {
    public static function Error( int $code ) : bool {
        $typeName = static::class;
        throw new $typeName( $code );
        return true;
    }

    public function __construct( int $code ) {
        parent::__construct( "Error[code:{$code}]", $code );
    }
}

