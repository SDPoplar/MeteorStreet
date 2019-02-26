<?php
use Mxs\Enum\FrameErrorCode as FEC;

return [
    '_def'                      => 'Unknown Error',

    FEC::WRONG_PARENT_PROCESS   => 'Given process should be subclass of Mxs\\Abstracts\\Process',

    FEC::INVALID_ROUTE          => 'Route not found',
];
