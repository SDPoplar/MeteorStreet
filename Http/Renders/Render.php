<?php
namespace Mxs\Http\Renders;

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
        self::setStatus(\Mxs\Http\Status::tryFrom($e->getCode()) ?: \Mxs\Http\Status::InternalServerError);
        //TODO: save error to log
        die($e->getMessage());
    }

    protected static function setStatus(\Mxs\Http\Status $status): void
    {
        header('HTTP/1.1 '.$status->value.' '.$status->translate());
    }
}
