<?php
namespace Mxs\Http\Renders;

class Json extends Render
{
    protected static function formatNormalContent(array $content): string
    {
        return json_encode($content);
    }
}
