<?php

function app(): \Mxs\App
{
    return \Mxs\App::get();
}

function config(string $key): mixed
{
    return app()->config->get($key);
}

if (!function_exists('env')) {
    function env(string $name, $def)
    {
        return app()->env->get($name, $def);
    }
}
