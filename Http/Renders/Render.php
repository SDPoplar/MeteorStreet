<?php
namespace Mxs\Http\Renders;

use \Mxs\Http\Status as HttpStatus;

abstract class Render
{
    abstract protected static function formatNormalContent(array $content): string;

    public static function render(\Mxs\Http\Response $response): never
    {
        self::setStatus($response->status);
        $fmted = is_array($response->content) ? self::formatNormalContent($response->content) : $response->content;
        die($fmted);
    }

    public static function redirect(\Mxs\Http\Response $response): never
    {
        self::setStatus($response->status);
        header('Location: '.$response->content);
        exit;
    }

    public static function error(\Error|\Exception $e): never
    {
        self::setStatus(HttpStatus::tryFrom($e->getCode()) ?: HttpStatus::InternalServerError);
        //TODO: save error to log
        die($e->getMessage());
    }

    protected static function setStatus(HttpStatus $status): void
    {
        header('HTTP/1.1 '.$status->value.' '.$status->translate());
    }
}
