<?php
namespace Mxs\Middlewares;

class Cors implements \Mxs\Gate\Middleware
{
    #[\Override]
    public function handle(\Mxs\Gate\Input $in, \Closure $next): mixed
    {
        $resp = $next($in);
        if ($resp instanceof \Mxs\Frame\ExecReturn) {
            $resp = $resp
                ->header("Access-Control-Allow-Methods: GET,POST,PUT,HEAD,DELETE")
                ->header("Access-Control-Allow-Origin: *")
                ->header("Access-Control-Allow-Headers: Authorization, Content-Type");
        } else if($resp instanceof \Psr\Http\Message\ResponseInterface) {
            $resp = $resp
                ->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,HEAD,DELETE')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type');
        }
        return $resp;
    }
}