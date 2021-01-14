<?php
namespace Mxs\Exceptions\DevelopExceptions;

class NeedImplementInterface extends DevelopBase
{
    public static function throm( string $invalidClassName, string $interfaceName ) : bool
    {
        return parent::throm( "class {$invalidClassName} should implement interface {$interfaceName}" );
    }
}

