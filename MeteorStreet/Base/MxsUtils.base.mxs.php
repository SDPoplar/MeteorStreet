<?php
namespace Mxs\Base;

class MxsUtils {
    static public function to_array( $obj, $sep = ',' ) {
        return is_array( $obj ) ? $obj : explode( $sep, $obj );
    }
}
