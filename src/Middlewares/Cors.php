<?php
namespace Mxs\Middlewares;

class Cors implements \Mxs\Gate\Middleware
{
    #[\Override]
    public function handle(\Mxs\Gate\Input $in, \Closure $next): mixed
    {
        $origin = $in instanceof \Mxs\Inputs\HttpRequest ? $in->header('Origin', '*') : '*';
        header("Access-Control-Allow-Methods: GET,POST,PUT,HEAD,DELETE", true);
        header("Access-Control-Allow-Origin: {$origin}", true);
        header("Access-Control-Allow-Headers: Authorization, Content-Type", true);
        header('Access-Control-Allow-Credentials: true', true);
        header("Vari: Origin", true);
        return $next($in);
    }
}