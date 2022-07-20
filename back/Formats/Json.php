<?php
namespace Mxs\Formats;

class Json
{
    public static function format( $data ) : string {
        return json_encode( $data );
    }
}

