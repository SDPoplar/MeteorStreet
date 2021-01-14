<?php
namespace Mxs\Requests;

abstract class Tool
{
    public static function getOriginRequest() : OriginRequest
    {
        $sponsorClass = self::getSponsorClass();
        $sponsor = new $sponsorClass();
        return $sponsor->loadOriginRequest();
    }

    private static function getSponsorClass() : string
    {
        if ($argc ?? $_SERVER[ 'argc' ] ?? 0 > 0) {
            return Sponsors\Shell::class;
        }

        if (function_exists( 'apache_request_headers ' )) {
            return Sponsors\Apache::class;
        }

        return Sponsors\Nginx::class;
    }
}

