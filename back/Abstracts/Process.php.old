<?php
namespace Mxs\Abstracts;

use \Mxs\Enums\ProcessStep as EStep;

abstract class Process
{
    const RUNNER_MAP = [
        EStep::DEPACK => \Mxs\Bases\Steps\Depack::class,
        EStep::REQUEST => \Mxs\Bases\Steps\Request::class,
        EStep::DISPATCH => \Mxs\Bases\Steps\Dispatch::class,
        EStep::RESPONSE => \Mxs\Bases\Steps\Response::class,
    ];

    abstract protected function plan() : void;

    final public function getSteps() : array
    {
        return $this->steps;
    }

    final public function valid() : bool
    {
        return empty( $this->missing );
    }

    final protected function depack( string $depackerClass ) : static
    {
        return $this->registStep( EStep::DEPACK, $depackerClass );
    }

    final protected function request( string $requestClass ) : static
    {
        return $this->registStep( EStep::REQUEST, $requestClass );
    }

    final protected function dispatch( string $routerClass ) : static
    {
        return $this->registStep( EStep::DISPATCH, $routerClass );
    }

    final protected function response( string $responseVendorClass ) : static
    {
        return $this->registStep( EStep::RESPONSE, $responseVendorClass );
    }

    private function registStep( $stepKey, ...$args ) : static
    {
        $runnerType = self::RUNNER_MAP[ $stepKey ];
        $this->steps[] = new $runnerType( ...$args );
        $this->missing = array_diff( $this->missing, [ $stepKey ] );
        return $this;
    }

    private array $steps = [];
    private array $missing = [ EStep::REQUEST, EStep::DISPATCH, EStep::RESPONSE ];
}

