<?php
namespace Mxs\Enums;

class HttpStatus extends \Mxs\Abstracts\Enum
{
    const COMMON = 200;
    const REDIRECT = 301;
    const FILE_NOT_FOUND = 404;
    const SCRIPT_ERROR = 500;
}

