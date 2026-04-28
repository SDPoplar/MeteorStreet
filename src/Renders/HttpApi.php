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

    protected function renderDevelopException(MxsDevException $e): bool
    {
        app()->logger->error($e->getMessage(), [
            'proposal' => $e->proposal
        ]);
        $err_msg = \Mxs\App::get()->debug
            ? '<h1>'.$e->getMessage().'</h1><p>'.$e->proposal.'</p>'
            : '';
        $this->writeHttpResponse($e->http_status->value, self::HTML_TYPE, $err_msg);
        return false;
    }
}
