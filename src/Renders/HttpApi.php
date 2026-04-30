<?php
namespace Mxs\Renders;

use \Mxs\Exceptions\Develops\MxsDevelop as MxsDevException;
use \Mxs\Exceptions\Runtimes\MxsRuntime as MxsRuntimeException;
use \SeaDrip\Http\Status as HttpStatus;

class HttpApi extends Http
{
    private const JSON_TYPE = 'application/json';

    #[\Override]
    public function onSuccess(mixed $response): void
    {
        //$content = $response->body;
        $content = ['msg' => 'hello'];
        $content = is_array($content) ? json_encode($content) : ''.$content;
        $status = empty($content) ? HttpStatus::NoContent : HttpStatus::OK;
        $this->writeHttpResponse($status->value, self::JSON_TYPE, $content);
    }

    #[\Override]
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
        if ($e->http_status === \SeaDrip\Http\Status::InternalServerError) {
            app()->logger->error(implode(PHP_EOL, array_merge([
                '['.$e->getCode().']'.$e->getMessage(),
            ], self::packExceptionTrace($e->getTrace()))));
        }
        $this->writeHttpResponse(
            $e->http_status->value,
            self::JSON_TYPE,
            json_encode([
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ])
        );
        return true;
    }
}
