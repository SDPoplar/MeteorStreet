<?php
namespace Mxs\Bases;

class RouteManager
{
    public static function create(string $method) : RouteManager
    {
        $res = class extends \Mxs\Abstracts\Compileable {
            protected static function isCompiled() : bool
            {
                return file_exists(self::makePath( 'route/map.php' ));
            }

            protected static function compile() : bool
            {
                return false;
            }

            protected static function readCompiled(string $flag)
            {
                $path = dirname(self::makePath('route/map.php'))."/{$flag}.php";
                return include( $path );
            }
        }::load($method);
    }

}

