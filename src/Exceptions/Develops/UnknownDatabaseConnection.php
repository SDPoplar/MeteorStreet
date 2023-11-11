<?php
namespace Mxs\Exceptions\Develops;

class UnknownDatabaseConnection extends MxsDevelop
{
    public function __construct(string $wanted, array $all_valid)
    {
        $proposal = empty($all_valid)
            ? 'use appendConnection in your database config to regist a connection'
            : 'valid connections: '.implode(', ', $all_valid);
        parent::__construct(
            'getting unknown database connection '.$wanted,
            $proposal,
        );
    }
}
