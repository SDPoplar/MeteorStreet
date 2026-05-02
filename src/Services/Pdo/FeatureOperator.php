<?php
namespace Mxs\Services\Pdo;

enum FeatureOperator
{
    case orGroup;
    case andGroup;
    case equal;
    case notEqual;
    case lessThan;
    case greaterThan;
    case lessThanOrEqual;
    case greaterThanOrEqual;
    case between;
    case in;
    case like;
}
