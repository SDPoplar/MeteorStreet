<?php
namespace Mxs\Defaults;

class Process extends \Mxs\Abstracts\Process
{
    public function plan() : void
    {
        $this
            ->request( \Mxs\Defaults\Request::class )
            ->dispatch( \Mxs\Routes\File::class )
            ->response( \Mxs\Formats\Json::class );
    }
}

