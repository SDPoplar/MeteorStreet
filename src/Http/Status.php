<?php
namespace Mxs\Http;

enum Status: int
{
    /**
     * 1xx - 信息提示
     * 这些状态代码表示临时的响应。客户端在收到常规响应之前，应准备接收一个或多个 1xx 响应。
     */
    case Continue = 100;                        //  初始的请求已经接受，客户应当继续发送请求的其余部分。（HTTP 1.1新） 
    case SwitchingProtocols = 101;              //  服务器将遵从客户的请求转换到另外一种协议（HTTP 1.1新）

    /**
     * 2xx - 成功
     * 这类状态代码表明服务器成功地接受了客户端请求。
     */
    case OK = 200;                              //  一切正常，对GET和POST请求的应答文档跟在后面。 
    case Created = 201;                         //  服务器已经创建了文档，Location头给出了它的URL。 
    case Accepted = 202;                        //  已经接受请求，但处理尚未完成。 
    case NonAuthoritativeInformation = 203;     //  文档已经正常地返回，但一些应答头可能不正确，因为使用的是文档的拷贝，非权威性信息（HTTP 1.1新）。
    case NoContent = 204;                       //  没有新文档，浏览器应该继续显示原来的文档。如果用户定期地刷新页面，而Servlet可以确定用户文档足够新，这个状态代码是很有用的。 
    case ResetContent = 205;                    //  没有新的内容，但浏览器应该重置它所显示的内容。用来强制浏览器清除表单输入内容（HTTP 1.1新）。 
    case PartialContent = 206;                  //  客户发送了一个带有Range头的GET请求，服务器完成了它（HTTP 1.1新）。

    /**
     * 3xx - 重定向
     * 客户端浏览器必须采取更多操作来实现请求。例如，浏览器可能不得不请求服务器上的不同的页面，或通过代理服务器重复该请求。
     */
    case MultipleChoices = 300;                 //  客户请求的文档可以在多个位置找到，这些位置已经在返回的文档内列出。如果服务器要提出优先选择，则应该在Location应答头指明。
    case MovedPermanently = 301;                //  客户请求的文档在其他地方，新的URL在Location头中给出，浏览器应该自动地访问新的URL。
    case Found = 302;                           //  类似于301，但新的URL应该被视为临时性的替代，而不是永久性的。
    /**
     * 注意，Status 302 在HTTP1.0中对应的状态信息是“Moved Temporatily”。
     * 出现该状态代码时，浏览器能够自动访问新的URL，因此它是一个很有用的状态代码。
     * 这个状态代码有时候可以和301替换使用。例如，如果浏览器错误地请求http://host/~user （缺少了后面的斜杠），有的服务器返回301，有的则返回302。
     * 严格地说，我们只能假定只有当原来的请求是GET时浏览器才会自动重定向。请参见307。
     */
    case SeeOther = 303;                        //  类似于301/302，不同之处在于，如果原来的请求是POST，Location头指定的重定向目标文档应该通过GET提取（HTTP 1.1新）。
    case NotModified = 304;                     //  客户端有缓冲的文档并发出了一个条件性的请求（一般是提供If-Modified-Since头表示客户只想比指定日期更新的文档）。
                                                //  服务器告诉客户，原来缓冲的文档还可以继续使用。
    case UseProxy = 305;                        //  客户请求的文档应该通过Location头所指明的代理服务器提取（HTTP 1.1新）。 
    case TemporaryRedirect = 307;               //  和302（Found）相同。许多浏览器会错误地响应302应答进行重定向，即使原来的请求是POST，即使它实际上只能在POST请求的应答是303时才能重定向。
                                                //  由于这个原因，HTTP 1.1新增了307，以便更加清除地区分几个状态代码：当出现303应答时，浏览器可以跟随重定向的GET和POST请求；
                                                //  如果是307应答，则浏览器只能跟随对GET请求的重定向。（HTTP 1.1新）

    /**
     * 4xx - 客户端错误
     * 发生错误，客户端似乎有问题。例如，客户端请求不存在的页面，客户端未提供有效的身份验证信息。
     */
    case BadRequest = 400;                      //  请求出现语法错误。    
    case Unauthorized = 401;                    //  访问被拒绝，客户试图未经授权访问受密码保护的页面。应答中会包含一个WWW-Authenticate头，浏览器据此显示用户名字/密码对话框，然后在填写合适的Authorization头后再次发出请求。
    /**
     * IIS 定义了许多不同的 401 错误，它们指明更为具体的错误原因。这些具体的错误代码在浏览器中显示，但不在 IIS 日志中显示：
     * 401.1 - 登录失败。
     * 401.2 - 服务器配置导致登录失败。
     * 401.3 - 由于 ACL 对资源的限制而未获得授权。
     * 401.4 - 筛选器授权失败。
     * 401.5 - ISAPI/CGI 应用程序授权失败。
     * 401.7 – 访问被 Web 服务器上的 URL 授权策略拒绝。这个错误代码为 IIS 6.0 所专用。
     */
    case Forbidden = 403;                       //  资源不可用。服务器理解客户的请求，但拒绝处理它。通常由于服务器上文件或目录的权限设置导致。
    /**
     * IIS 定义了许多不同的 403 错误，它们指明更为具体的错误原因：
     * 403.1 - 执行访问被禁止。
     * 403.2 - 读访问被禁止。
     * 403.3 - 写访问被禁止。
     * 403.4 - 要求 SSL。
     * 403.5 - 要求 SSL 128。
     * 403.6 - IP 地址被拒绝。
     * 403.7 - 要求客户端证书。
     * 403.8 - 站点访问被拒绝。
     * 403.9 - 用户数过多。
     * 403.10 - 配置无效。
     * 403.11 - 密码更改。
     * 403.12 - 拒绝访问映射表。
     * 403.13 - 客户端证书被吊销。
     * 403.14 - 拒绝目录列表。
     * 403.15 - 超出客户端访问许可。
     * 403.16 - 客户端证书不受信任或无效。
     * 403.17 - 客户端证书已过期或尚未生效。
     * 403.18 - 在当前的应用程序池中不能执行所请求的 URL。这个错误代码为 IIS 6.0 所专用。
     * 403.19 - 不能为这个应用程序池中的客户端执行 CGI。这个错误代码为 IIS 6.0 所专用。
     * 403.20 - Passport 登录失败。这个错误代码为 IIS 6.0 所专用。
     */
    case NotFound = 404;                        //  无法找到指定位置的资源。这也是一个常用的应答。
    /**
     * 404.0 -（无） – 没有找到文件或目录。
     * 404.1 - 无法在所请求的端口上访问 Web 站点。
     * 404.2 - Web 服务扩展锁定策略阻止本请求。
     * 404.3 - MIME 映射策略阻止本请求。
     */
    case MethodNotAllowed = 405;                //  请求方法（GET、POST、HEAD、DELETE、PUT、TRACE等）对指定的资源不适用，用来访问本页面的 HTTP 谓词不被允许（方法不被允许）（HTTP 1.1新）
    case NotAcceptable = 406;                   //  指定的资源已经找到，但它的MIME类型和客户在Accpet头中所指定的不兼容，客户端浏览器不接受所请求页面的 MIME 类型（HTTP 1.1新）。
    case ProxyAuthenticationRequired = 407;     //  要求进行代理身份验证，类似于401，表示客户必须先经过代理服务器的授权。（HTTP 1.1新） 
    case RequestTimeout = 408;                  //  在服务器许可的等待时间内，客户一直没有发出任何请求。客户可以在以后重复同一请求。（HTTP 1.1新）
    case Conflict = 409;                        //  通常和PUT请求有关。由于请求和资源的当前状态相冲突，因此请求不能成功。（HTTP1.1新）
    case Gone = 410;                            //  所请求的文档已经不再可用，而且服务器不知道应该重定向到哪一个地址。它和404的不同在于，返回410表示文档永久地离开了指定的位置，而404表示由于未知的原因文档不可用。（HTTP 1.1新） 
    case LengthRequired = 411;                  //  服务器不能处理请求，除非客户发送一个Content-Length头。（HTTP 1.1新）
    case PreconditionFailed = 412;              //  请求头中指定的一些前提条件失败（HTTP 1.1新）。
    case RequestEntityTooLarge = 413;           //  目标文档的大小超过服务器当前愿意处理的大小。如果服务器认为自己能够稍后再处理该请求，则应该提供一个Retry-After头（HTTP 1.1新）。
    case RequestURITooLong = 414;               //  URI太长（HTTP 1.1新）。 
    //  · 415 – 不支持的媒体类型。
    case RequestedRangeNotSatisfiable = 416;    //  服务器不能满足客户在请求中指定的Range头。（HTTP 1.1新）。 
    //  · 417 – 执行失败。
    //  · 423 – 锁定的错误。

    /**
     * 5xx - 服务器错误
     * 服务器由于遇到错误而不能完成该请求。
     */
    case InternalServerError = 500;             //  服务器遇到了意料不到的情况，不能完成客户的请求。
    /**
     * 500.12 - 应用程序正忙于在 Web 服务器上重新启动。
     * 500.13 - Web 服务器太忙。
     * 500.15 - 不允许直接请求 Global.asa。
     * 500.16 - UNC 授权凭据不正确。这个错误代码为 IIS 6.0 所专用。
     * 500.18 - URL 授权存储不能打开。这个错误代码为 IIS 6.0 所专用。
     * 500.100 - 内部 ASP 错误。
     */
    case NotImplemented = 501;                  //  服务器不支持实现请求所需要的功能，页眉值指定了未实现的配置。例如，客户发出了一个服务器不支持的PUT请求。
    case BadGateway = 502;                      //  服务器用作网关或代理服务器时收到了无效响应。
    /**
     * 502.1 - CGI 应用程序超时。
     * 502.2 - CGI 应用程序出错。
     */
    case ServiceUnavailable = 503;              //  服务不可用，服务器由于维护或者负载过重未能应答。例如，Servlet可能在数据库连接池已满的情况下返回503。
                                                //  服务器返回503时可以提供一个Retry-After头。这个错误代码为IIS 6.0 所专用。
    case GatewayTimeout = 504;                  //  网关超时，由作为代理或网关的服务器使用，表示不能及时地从远程服务器获得应答。（HTTP 1.1新） 。
    case HttpVersionNotSupported = 505;         //  服务器不支持请求中所指明的HTTP版本。（HTTP 1.1新）。
    
    public function translate(): string
    {
        $ret = match($this) {
            //  2xx
            self::NonAuthoritativeInformation => 'Non-Authoritative Information',
            self::NoContent => 'No Content',
            self::ResetContent => 'Reset Content',
            self::PartialContent => 'Partial Content',

            //  3xx
            self::MovedPermanently => 'Moved Permanently',
            self::SeeOther => 'See Other',
            self::NotModified => 'Not Modified',
            self::UseProxy => 'Use Proxy',
            self::TemporaryRedirect => 'Temporary Redirect',

            //  4xx
            self::BadRequest => 'Bad Request',
            self::NotFound => 'Not Found',
            self::MethodNotAllowed => 'Method Not Allowed',
            self::NotAcceptable => 'Not Acceptable',
            self::ProxyAuthenticationRequired => 'Proxy Authentication Required',
            self::RequestTimeout => 'Request Timeout',
            self::LengthRequired => 'Length Required',
            self::PreconditionFailed => 'Precondition Failed',
            self::RequestEntityTooLarge => 'Request Entity Too Large',
            self::RequestURITooLong => 'Request URI Too Long',
            self::RequestedRangeNotSatisfiable => 'Requested Range Not Satisfiable',

            //  5xx
            self::InternalServerError => 'Internal Server Error',
            self::NotImplemented => 'Not Implemented',
            self::BadGateway => 'Bad Gateway',
            self::ServiceUnavailable => 'Service Unavailable',
            self::GatewayTimeout => 'Gateway Timeout',
            self::HttpVersionNotSupported => 'HTTP Version Not Supported',
            
            default => null,
        };
        return $ret ?: $this->name;
    }

    public function getGroup(): int
    {
        return floor($this->value / 100);
    }
}
