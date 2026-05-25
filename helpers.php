<?php

function app(): \Mxs\App
{
    return \Mxs\App::get();
}

function config(string $key, mixed $def = null): mixed
{
    return app()->config->get($key, $def);
}

if (!function_exists('env')) {
    function env(string $name, mixed $def = null)
    {
        return app()->env->get($name, $def);
    }
}
