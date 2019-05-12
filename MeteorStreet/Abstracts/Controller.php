<?php
namespace Mxs\Abstracts;

abstract class Controller {
    const NAMESPACE_PREFIX = 'App\\Controller\\';

    protected final function Error( int $errCode ) : bool {
        throw new \Mxs\Error\AppError( $errCode );
        return true;
    }

    public static function ValidControllerName( $name ) : string {
        return ( stripos( $name, self::NAMESPACE_PREFIX ) === 0 )
            ? $name : self::NAMESPACE_PREFIX.$name;
    }
}

