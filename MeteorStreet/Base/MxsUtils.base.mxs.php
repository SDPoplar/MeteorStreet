<?php
namespace MxsClass\Base;

class MxsUtils {
    static public function to_array( $obj, $sep = ',' ) {
        return is_array( $obj ) ? $obj : explode( $sep, $obj );
    }
}
