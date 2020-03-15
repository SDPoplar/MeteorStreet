<?php
trait KeyValueMapTrait
{
    public function merge( array ...$kvmap ) {
        $this->_items = array_merge( $this->_items, $kvmap );
    }

    protected getItem( string $keyName, $defValue = null ) {
        return $_items[ $keyName ] ?? $defValue;
    }

    protected $_items = [];
}

