<?php
namespace Mxs\Enums;

class RequestIncludeInput extends \Mxs\Abstracts\Enum
{
    const GET           = 1;    //  0x00001
    const POST          = 2;    //  0x00010
    const STREAM        = 4;    //  0x00100
    const UPLOAD        = 8;    //  0x01000
    const ROUTE         = 16;   //  0x10000
}

