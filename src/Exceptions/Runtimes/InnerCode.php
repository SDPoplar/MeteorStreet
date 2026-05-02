<?php
namespace Mxs\Exceptions\Runtimes;

enum InnerCode: int
{
    case LoadDocumentRootFailed = 900;
    case CannotCreatePath = 901;
    case CannotReadFile = 902;
    case RouteNotFound = 903;
    case UnknownHttpMethod = 904;
    case InvalidInput = 905;
    case ConnectServiceFailed = 906;
    case NoWritePermission = 907;
    case ReceiveFileFailed = 908;
}
