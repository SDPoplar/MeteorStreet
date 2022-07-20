<?php
namespace Mxs\Bases\Steps;

class Request extends \Mxs\Abstracts\StepRunner
{
    public function __construct()
    {}

    public function run( string $useRequest )
    {
        var_dump( $useRequest ); exit;
    }
}

