<?php
namespace Mxs\Renders;

use Mxs\Frame\{ExecReturn, ExecReturnType};

class HttpHtml extends Http
{
    function onSuccess(mixed $response): void
    {
        if ($response instanceof ExecReturn and $response->type === ExecReturnType::Redir) {
            $this->redirect($response->data);
            return;
        }

        //  TODO
    }
}
