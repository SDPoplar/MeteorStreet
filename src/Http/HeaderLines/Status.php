<?php
namespace Mxs\Http\HeaderLines;

readonly class Status
{
    public function __construct(
        public \SeaDrip\Http\Status $status = \SeaDrip\Http\Status::OK,
        public string $reason_phrase = '',
    ) {}
}
