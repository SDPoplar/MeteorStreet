<?php
namespace Mxs\Tools;
use \Mxs\Tools\PathFormator as PF;

class Language extends \Mxs\Abstracts\Single
{
    public static function content( string $group, $key ) : string {
        return ( Language::get()->getGroup( $group ) )[ $key ] ?? '';
    }

    protected function init() {
        $lang = \Mxs\Core::get()->environment->getUserLang();
        $this->_mxs_lang_path = PF::EndDirSep( PF::Concat( $env->getMxsResourcePath(), 'lang', $lang ) );
        $this->_app_lang_path = PF::EndDirSep( PF::Concat( $env->getLangPath(), $lang ) );
    }

    protected function &getGroup( string $group ) : array {
        if( !array_key_exists( $group, $this->_contents ) ) {
            $mxsLangFile = $this->_mxs_lang_path.$group.'.php';
            $appLangFile = $this->_app_lang_path.$group.'.php';
            $this->_contents[ $group ] = array_merge(
                file_exists( $mxsLangFile ) ? include( $mxsLangFile ) : [],
                file_exists( $appLangFile ) ? include( $appLangFile ) : []
            ); 
        }
        return $this->_contents[ $group ];
    }

    protected $_contents = [];
    protected $_mxs_lang_path;
    protected $_app_lang_path;
}

