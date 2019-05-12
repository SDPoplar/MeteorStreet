<?php
namespace Mxs\Error;

class AppError extends MxsError {
    protected function _getLangPath() : string {
        return \Mxs\Util\PathUtil::CheckPath( SRC_PATH.'lang/error/' );
    }

    protected function _getDefMessage() : string {
        return 'App Runtime Error';
    }
}

