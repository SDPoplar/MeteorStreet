<?php
namespace Mxs\Exceptions\Develops;

abstract class MxsDevelop extends \LogicException
{
    use \Mxs\Exceptions\MxsExceptionTrait;

    public function __construct(
        string $message,
        public readonly string $proposal,
        public readonly \SeaDrip\Http\Status $http_status = \SeaDrip\Http\Status::InternalServerError
    ) {
        parent::__construct($message);
    }
}
