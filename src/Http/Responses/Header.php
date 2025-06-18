<?php
namespace Mxs\Http\Responses;

use \SeaDrip\Http\Status as HttpStatus;

class Header
{
    public function __construct(
        protected HttpStatus $status = HttpStatus::OK,
    ) {   
    }

    public function getStatusCode(): string
    {
        return $this->status->value;
    }
}
