<?php
{
    $ext = '.base.mxs.php';
    $path = MXS_PATH.'Base'.DIRECTORY_SEPARATOR;
    require_once( $path.'Defcfg'.$ext );
    require_once( $path.'Router'.$ext );
    require_once( $path.'Io'.$ext );
    require_once( $path.'Crypter'.$ext );
    require_once( $path.'Logger'.$ext );
    require_once( $path.'Engine'.$ext );
}
