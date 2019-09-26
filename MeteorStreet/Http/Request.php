<?php
namespace Mxs\Http;

use \Mxs\Enums\RequestIncludeInput as RII;

class Request
{
    protected $_include_input = RII::GET | RII::POST;
}

