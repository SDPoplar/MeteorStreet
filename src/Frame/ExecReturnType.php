<?php
namespace Mxs\Frame;

enum ExecReturnType
{
    case Redir;
    case Created;
    case Success;
}