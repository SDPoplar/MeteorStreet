<?php
namespace Mxs\Abstracts;

abstract class Controller {
    protected final function Error( int $errCode ) : bool {
        throw new \Mxs\Error\AppError( $errCode );
        return true;
    }
}

