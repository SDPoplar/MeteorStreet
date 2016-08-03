<?php
namespace MxsClass\Base;

class MxsException extends \Exception {
    public function __construct( $e ) {
        parent::__construct( 'Error:'.$e, $e );
    }
}
