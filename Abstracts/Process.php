<?php
namespace Mxs\Abstracts;

abstract class Process
{
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
        return $this->registStep( 'depack', $depackerClass );
    }

    final protected function request() : static
    {
        return $this->registStep( 'request' );
    }

    final protected function dispatch( string $routerClass ) : static
    {
        return $this->registStep( 'dispatch', $routerClass );
    }

    final protected function response( string $responseVendorClass ) : static
    {
        return $this->registStep( 'response', $responseVendorClass );
    }

    private function registStep( $stepKey, ...$args ) : static
    {
        $this->steps[] = [
            'step' => $stepKey,
            'args' => $args,
        ];
        $this->missing = array_diff( $this->missing, [ $stepKey ] );
        return $this;
    }

    private array $steps = [];
    private array $missing = [ 'request', 'dispatch', 'response' ];
}

