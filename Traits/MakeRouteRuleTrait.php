<?php
namespace Mxs\Traits;
use \Mxs\Bases\Route\Rules\{Redirect, Dispatch};
use \Mxs\Enums\AllowRequestMethod as ARM;

trait MakeRouteRuleTrait
{
    public function redirect( string $match, string $target, int $delay = 0 ) : Redirect {
        return ( new Redirect( $match ) )->target( $target )->delay( $delay );
    }

    public function shell( string $match ) : Dispatch {
        return $this->dispatch( ARM::SHELL );
    }

    public function get( string $match ) : Dispatch {
        return $this->dispatch( ARM::GET, $match );
    }

    public function post( string $match ) : Dispatch {
        return $this->dispatch( ARM::POST, $match );
    }

    public function http( string $match ) : Dispatch {
        return $this->dispatch( ARM::All( ARM::SHELL ), $match );
    }

    public function any( string $match ) : Dispatch {
        return $this->dispatch( ARM::All(), $match );
    }

    protected function dispatch( int $allowMethod, string $match ) : Dispatch {
        return ( new Dispatch( $match ) )->allow( $allowMethod );
    }
}

