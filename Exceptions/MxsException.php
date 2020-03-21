<?php
namespace Mxs\Exceptions;

class MxsException extends \Exception {
    const LANG_STR_KEY = "lang_key_";

    public static function SKey( int $code ) : string {
        return self::LANG_STR_KEY.$code;
    }

    public static function Error( int $code ) : bool {
        $typeName = static::class;
        throw new $typeName( $code );
        return true;
    }

    public function __construct( int $code ) {
        $lang = \Mxs\Tools\Language::content( 'error', "lang_key_{$code}" );
        parent::__construct( $lang, $code );
    }
}

