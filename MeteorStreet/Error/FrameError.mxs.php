<?php
namespace Mxs\Error;

class FrameError extends \Exception {
    const LANG_FILE_SUFFIX = '.lang.php';

    public function __construct( $errCode ) {
        $langPath = MXS_PATH.'Lang/Error/';
        $lang = GetMxs()->getRequest()->getLanguage();
        $targetFile = "{$langPath}{$lang}".self::LANG_FILE_SUFFIX;
        $defFile = "{$langPath}en".self::LANG_FILE_SUFFIX;
        $msg = \Mxs\Util\ArrayFromFile::FindArrayItem( $errCode, $targetFile, $defFile );
        parent::__construct( $msg ?: 'Mxs Frame Error', $errCode );
    }
}

