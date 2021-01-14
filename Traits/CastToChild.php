<?php
namespace Mxs\Traits;

use \ReflectionProperty as RP;

trait CastToChild
{
    public function cast( string $childType ) : ?self
    {
        if (!is_subclass_of( $childType, self::class )) {
            return null;
        }
        $refchild = new \ReflectionClass( $childType );
        if ($refchild->isAbstract()) {
            //  throw dev exception - cannot cast to a abstract class
            return null;
        }
        if (!$refchild->implementsInterface( \Mxs\Interfaces\CastChild::class )) {
            //  throw dev exception - need implements cast-child interface
            return null;
        }
        $child = $refchild->newInstanceWithoutConstructor();
        $propLimit = RP::IS_PUBLIC | RP::IS_PROTECTED | RP::IS_PRIVATE;
        foreach ((new \ReflectionClass( self::class ))->getProperties( $propLimit ) as $prop) {
            $child->$prop = $this->$prop;
        }
        if ($child->afterBeenCasted() === false) {  //  true or null both means success
            //  throw runtime exception - class cast failed
            return null;
        }
        return $child;
    }
}

