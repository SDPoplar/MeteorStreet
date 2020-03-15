<?php
namespace Mxs\Traits;

trait KeyValueMapTrait
{
    public function &merge( array ...$kvmap ) : int {
        foreach( $kvmap as $item ) {
            $this->_items = array_merge( $this->_items, $kvmap );
        }

        return count( $kvmap );
    }

    protected function getItem( string $keyName, $defValue = null ) {
        return $_items[ $keyName ] ?? $defValue;
    }

    protected $_items = [];
}

