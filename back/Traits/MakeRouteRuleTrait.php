<?php
namespace Mxs\Traits;
use \Mxs\Routes\Rules\{Redirect, Dispatch};
use \Mxs\Enums\AllowRequestMethod as ARM;

trait MakeRouteRuleTrait
{
    public function getRules() : array {
        return $this->_rules;
    }

    public function &redirect( string $match, string $target, int $delay = 0 ) : Redirect {
        $rule = ( new Redirect( $match ) )->target( $target )->delay( $delay );
        array_push( $this->_rules, $rule );
        return $rule;
    }

    public function &shell( string $match ) : Dispatch {
        return $this->dispatch( ARM::SHELL, $match );
    }

    public function &get( string $match ) : Dispatch {
        return $this->dispatch( ARM::GET, $match );
    }

    public function &post( string $match ) : Dispatch {
        return $this->dispatch( ARM::POST, $match );
    }

    public function &http( string $match ) : Dispatch {
        return $this->dispatch( ARM::All( ARM::SHELL ), $match );
    }

    public function &any( string $match ) : Dispatch {
        return $this->dispatch( ARM::All(), $match );
    }

    protected function &dispatch( int $allowMethod, string $match ) : Dispatch {
        $rule = ( new Dispatch( $match ) )->allow( $allowMethod );
        array_push( $this->_rules, $rule );
        return $rule;
    }

    protected $_rules = [];
}

