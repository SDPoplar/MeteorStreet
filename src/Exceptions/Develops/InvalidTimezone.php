<?php
namespace Mxs\Exceptions\Develops;

class InvalidTimezone extends MxsDevelop
{
    public function __construct(string $given)
    {
        parent::__construct(
            'Invalid timezone ' . $given,
            'you should define a valid timezone in your .env file with APP_TIMEZONE column'
        );
    }
}
