<?php
namespace Mxs\Frame\Requests;

interface BaseInterface
{
    public function cast(string $children_type): \Psr\Http\Message\RequestInterface;
}
