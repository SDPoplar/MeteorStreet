<?php
namespace Mxs\Error;

class MxsError extends \Exception {
    const LANG_FILE_SUFFIX = '.lang.php';

    abstract protected function _getLangPath() : string;
    abstract protected function _getDefMessage() : string;

    public function __construct( int $errCode ) {
        $langPath = $this->_getLangPath();
        $lang = GetMxs()->getRequest()->getLanguage();
        $targetFile = "{$langPath}{$lang}".self::LANG_FILE_SUFFIX;
        $defFile = "{$langPath}en".self::LANG_FILE_SUFFIX;
        $langFile = new \Mxs\Channel\ArrayFileChannel( $targetFile, $defFile );
        $msg = $langFile->valid()
            ? $langFile->get( \Mxs\Base\ChannelPattern::Keys( $errCode ) )
            : null;
        parent::__construct( $msg ?: $this->_getDefMessage(), $errCode );
    }
}
