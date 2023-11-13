<?php

function app(): \Mxs\App
{
    return \Mxs\App::get();
}

if (!function_exists('env')) {
    function env(string $name, $def)
    {
        return app()->env->get($name, $def);
    }
}
