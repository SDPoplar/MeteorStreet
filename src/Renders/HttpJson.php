<?php
namespace Mxs\Renders;

use Mxs\Exceptions\Develops\MxsDevelop;
use SeaDrip\Http\Header;
use Override;

class HttpJson extends Http
{
    #[Override]
    protected function formatBody(mixed $data): string
    {
        return match(true) {
            is_array($data) => json_encode($data),
            is_null($data) => '',
            default => "{$data}",
        };
    }

    #[Override]
    protected function formatException(\Throwable $e): string
    {
        $base = [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ];
        if (app()->debug) {
            if ($e instanceof MxsDevelop) {
                $base['proposal'] = $e->proposal;
            }
            $base['trace'] = $e->getTrace();
        }
        return json_encode($base);
    }

    #[Override]
    protected static function getContentType(): Header
    {
        return Header::ContentType('application/json');
    }
}
