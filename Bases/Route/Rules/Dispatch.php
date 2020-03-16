<?php
namespace Mxs\Bases\Route\Rules;

class Dispatch extends Base
{
    public function &allow( int $allowed ) : Dispatch {
        $this->_allowed_method = $allowed;
        return $this;
    }

    protected $_allowed_method = 0;
}

