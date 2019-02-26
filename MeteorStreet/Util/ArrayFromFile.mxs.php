<?php
namespace Mxs\Util;

class ArrayFromFile {
    const DEF_COLUMN_KEY = '_def';

    public static function LoadArray( $targetFile, $defFile ) {
        $arr = self::_LoadArrayFromFile( $targetFile );
        return empty( $arr ) ? self::_LoadArrayFromFile( $defFile ) : $arr;
    }

    public static function FindArrayItem( $item, $targetFile, $defFile ) {
        $arr = self::_LoadArrayFromFile( $targetFile );
        $val = self::_FindItemFromArray( $arr, $item );
        return $val ?: self::_FindItemFromArray( self::_LoadArrayFromFile( $defFile ), $item );
    }

    protected static function _LoadArrayFromFile( $file ) : array {
        if( !is_readable( $file ) ) {
            return [];
        }

        $arr = include( $file );
        return is_array( $arr ) ? $arr : [];
    }

    protected static function _FindItemFromArray( $arr, string $item, $defValue = null ) {
        if( ( $defValue === null ) && array_key_exists( self::DEF_COLUMN_KEY, $arr ) ) {
            $defValue = $arr[ self::DEF_COLUMN_KEY ];
        }
        $keys = explode( '.', $item );
        $ret = $arr;
        foreach( $keys as $key ) {
            if( !array_key_exists( $key, $ret ) ) {
                return $defValue;
            }
            $ret = $ret[ $key ];
        }
        return $ret;
    }
}

