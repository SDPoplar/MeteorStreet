<?php
namespace Mxs\Error;

class FrameError extends MxsError {
    protected function _getLangPath() : string {
        return MXS_PATH.'Lang/Error/';
    }

    protected function _getDefMessage() : string {
        return 'Mxs Frame Error';
    }
}

