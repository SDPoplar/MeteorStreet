<?php
namespace Mxs\Exceptions\Develops;

class CommandNotFound extends MxsDevelop
{
    public function __construct(string $command)
    {
        parent::__construct(
            'Unknown command '.$command,
            'use php mxs list to view all commands, or regist your custom command in App\\Console\\Kernal::commands'
        );
    }
}
