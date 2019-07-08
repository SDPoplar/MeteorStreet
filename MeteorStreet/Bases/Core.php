<?php
namespace Mxs\Bases;

class Core extends \Mxs\Abstracts\Single
{
    use \Mxs\Traits\InitableTrait, \Mxs\Traits\LastErrorTrait;

    protected function init()
    {}

    public function valid() : bool
    {
        return true;
    }

    final public function run()
    {
        $this->valid() or die( $this->getLastErrorMessage() );
    }
}

