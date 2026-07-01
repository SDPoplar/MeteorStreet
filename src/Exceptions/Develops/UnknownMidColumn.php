<?php
namespace Mxs\Exceptions\Develops;

class UnknownMidColumn extends MxsDevelop
{
    public function __construct(string $column, string $current_class)
    {
        parent::__construct(
            "Unknown mid column {$column}",
            "this column is needed by {$current_class},"
                . ' please make sure you\'ve regist the middleware'
                . " which will give column {$column} before it"
        );
    }
}