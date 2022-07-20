<?php
namespace Mxs\Requests\Sponsors;

abstract class HttpSponsor
{
    public function loadOriginRequest() : \Mxs\Requests\OriginRequest
    {
        return new \Mxs\Requests\OriginRequest();
    }
}

