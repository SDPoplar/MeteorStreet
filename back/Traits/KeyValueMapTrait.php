<?php
namespace Mxs\Traits;

trait KeyValueMapTrait
{
    public function merge( array ...$kvmap ) : int {
        foreach( $kvmap as $item ) {
            $this->_items = array_merge( $this->_items, $kvmap );
        }

        return count( $kvmap );
    }

    protected function getItem( string $keyName, $defValue = null ) {
        $keys = explode( $keyName );
        $tree = $this->_items;
        foreach( $keys as $key ) {
            $tree = ( is_array( $tree ) && array_key_exists( $key, $tree ) )
                ? $tree[ $key ] : null;
        }
        return $tree ?? $defValue;
    }

    protected $_items = [];
}

