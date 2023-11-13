<?php
/*
if (function_exists('env')) {
    function env(string $name, $def)
    {
        return $def;
    }
}
*/

function app(): \Mxs\App
{
    return \Mxs\App::get();
}
