<?php
namespace Mxs\Middlewares;

class Cors implements \Mxs\Gate\Middleware
{
    #[\Override]
    public function handle(\Mxs\Gate\Input $in, \Closure $next): mixed
    {
        $origin = $in instanceof \Mxs\Inputs\HttpRequest ? $in->header('Origin', '*') : '*';
        //  app()->logger->info('got request header origin = ' . $origin);
        $resp = $next($in);
        if ($resp instanceof \Mxs\Frame\ExecReturn) {
            $resp = $resp
                ->header("Access-Control-Allow-Methods: GET,POST,PUT,HEAD,DELETE")
                ->header("Access-Control-Allow-Origin: {$origin}")
                ->header("Access-Control-Allow-Headers: Authorization, Content-Type")
                ->header("Vari: Origin")
                ->header('Access-Control-Allow-Credentials: true');
        } else if($resp instanceof \Psr\Http\Message\ResponseInterface) {
            $resp = $resp
                ->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,HEAD,DELETE')
                ->withHeader('Access-Control-Allow-Origin', $origin)
                ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type')
                ->withHeader('Vari', 'Origin')
                ->withHeader('Access-Control-Allow-Credentials', 'true');
        }
        return $resp;
    }
}