<?php
namespace Mxs\Renders;

use DateTime;
use \Mxs\Exceptions\Develops\MxsDevelop as MxsDevException;
use \Mxs\Exceptions\Runtimes\MxsRuntime as MxsRuntimeException;

class HttpApi extends \Mxs\Frame\Render
{
    public function __construct(\Mxs\Inputs\HttpRequest $request)
    {
        parent::__construct($request);
        $this->protocal_line = $request->protocal.'/'.$request->protocal_version;
        //var_dump($request);
    }

    public function onSuccess($response): void
    {
        $this->renderHttpResponse(json_encode(['msg' => 'hello']), 200);
    }

    public function onException(\Throwable $e): bool
    {
        if ($e instanceof MxsRuntimeException) {
            return $this->renderRuntimeException($e);
        }

        if ($e instanceof MxsDevException) {
            return $this->renderDevelopException($e);
        }

        return parent::onException($e);
    }

    protected function renderRuntimeException(MxsRuntimeException $e): bool
    {
        $this->renderHttpResponse(json_encode([
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ]), $e->http_status->value);
        return true;
    }

    protected function renderDevelopException(MxsDevException $e): bool
    {
        var_dump($e);
        return false;
    }

    protected function renderHttpResponse(string $response, int $http_status): void
    {
        header("HTTP/1.1 {$http_status}");
        header('Date: '.(new DateTime())->format(DateTime::RFC1123));
        header('Content-Type: application/json');
        header('Content-Length: '.strlen($response));
        echo $response;
    }

    protected readonly string $protocal_line;
}
