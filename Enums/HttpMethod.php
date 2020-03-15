<?php
namespace Mxs\Enums;

class HttpMethod extends \Mxs\Abstracts\Enum
{
    const GET           = 1;    //  0x000000001
    const POST          = 2;    //  0x000000010
    const HEAD          = 4;    //  0x000000100
    const PATCH         = 8;    //  0x000001000
    const PUT           = 16;   //  0x000010000
    const DELETE        = 32;   //  0x000100000
    const OPTIONS       = 64;   //  0x001000000
    const TRACE         = 128;  //  0x010000000
    const MOVE          = 256;  //  0x100000000

    public static function FromString( string $method ) : int {
        switch( strtoupper( $method ) ) {
            case 'GET':
                return self::GET;
            case 'POST':
                return self::POST;
            case 'HEAD':
                return self::HEAD;
            case 'PATCH':
                return self::PATCH;
            case 'PUT':
                return self::PUT;
            case 'DELETE':
                return self::DELETE;
            case 'OPTIONS':
                return self::OPTIONS;
            case 'TRACE':
                return self::TRACE;
            case 'MOVE':
                return self::MOVE;
            default:
                return 0;
        }
    }
}

