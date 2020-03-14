<?php
namespace Mxs\Bases;

use \Mxs\Enums\RequestIncludeInput as RII;

class Request
{
    public function &merge( array $items ) : Request {
        empty( $items ) || ( $this->_inputs = array_merge( $this->_inputs, $items ) );
        return $this;
    }

    public function init( int $httpMethod, $inputLimit ) {
        $this->_inputs = array_merge( $this->_inputs, $_GET, $_POST );
        $this->_uploads = array_merge( $this->_uploads, $_FILES ?? [] );
    }

    protected $_include_input = RII::GET | RII::POST;
    protected $_inputs = [];
    protected $_uploads = [];
}

