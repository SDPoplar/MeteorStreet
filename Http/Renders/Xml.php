<?php
namespace Mxs\Http\Renders;

class Xml extends Render
{
    protected static function formatNormalContent(array $content): string
    {
        foreach ($content as $key => $val) {
            $line[] = "<{$key}>{$val}</{$key}>";
        }
        return '<xml>'.implode('', $line ?? []).'</xml>';
    }
}
