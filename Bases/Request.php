<?php
namespace Mxs\Bases;

use \Mxs\Enums\RequestIncludeInput as RII;

class Request
{
    public function &merge( array $items ) : Request {
        empty( $items ) || ( $this->_inputs = array_merge( $this->_inputs, $items ) );
        return $this;
    }

    protected $_include_input = RII::GET | RII::POST;
    protected $_inputs = [];
}

