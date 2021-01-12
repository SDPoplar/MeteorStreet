<?php
namespace Mxs\Defaults;

class Process extends \Mxs\Abstracts\Process
{
    public function plan() : void
    {
        $this
            ->request()
            ->dispatch( \Mxs\Routes\File::class )
            ->response( \Mxs\Formats\Json::class );
    }
}

