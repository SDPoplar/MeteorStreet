<?php
namespace Mxs\Renders;

use SeaDrip\Http\Status as HttpStatus;
use Mxs\Exceptions\Runtimes\MxsRuntime as MxsRuntimeException;
use Mxs\Frame\{ExecReturn, ExecReturnType};

class HttpApi extends Http
{
    private const JSON_TYPE = 'application/json';

    #[\Override]
    public function onSuccess(mixed $response): void
    {
        if ($response instanceof ExecReturn) {
            if ($response->type === ExecReturnType::Redir) {
                $this->redirect($response->data);
                return;
            }
            if ($response->type === ExecReturnType::Created) {
                $status = HttpStatus::Created;
            }
            $content = $response->data;
        } else {
            //$content = $response->body;
            //$content = ['msg' => 'hello'];
            $content = $response;
        }
        $content = is_array($content) ? json_encode($content) : ''.$content;
        $status ??= empty($content) ? HttpStatus::NoContent : HttpStatus::OK;
        $this->writeHttpResponse($status->value, self::JSON_TYPE, $content);
    }

    #[\Override]
    public function onException(\Throwable $e): bool
    {
        if ($e instanceof MxsRuntimeException) {
            return $this->renderRuntimeException($e);
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
}
