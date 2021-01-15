<?php
namespace Mxs\Bases;

abstract class StepFactory
{
    public static function build( $stepInfo ) : \Mxs\Bases\Steps\Runner
    {
        var_dump( $stepInfo ); exit;
        return null;
    }
}

