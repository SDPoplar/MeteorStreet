<?php
namespace Mxs\Configs;

enum PdoTypes: string
{
    case MySql = 'mysql';
    case MongoDB = 'mongo';
    case Sqlite = 'sqlite';
}
