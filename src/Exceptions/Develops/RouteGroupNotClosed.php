<?php
namespace Mxs\Exceptions\Develops;

class RouteGroupNotClosed extends MxsDevelop
{
    public function __construct(string $file_name)
    {
        $proposal = "Please check [{$file_name}] to confirm whether the unsupported route method is called in group callback";
        return parent::__construct('RouteGroup not closed', $proposal);
    }
}
