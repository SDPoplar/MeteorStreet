<?php
namespace Mxs\Http\Responses;

use \SeaDrip\Http\Status as HttpStatus;

class Header
{
    public function getStatusCode(): string
    {
        return $this->status->value;
    }
    
    protected HttpStatus $status = HttpStatus::OK;
}
