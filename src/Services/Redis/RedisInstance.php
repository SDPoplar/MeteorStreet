<?php
namespace Mxs\Services\Redis;

use Mxs\Exceptions\Runtimes\ConnectServiceFailed;

class RedisInstance extends \Redis implements RedisFacadeInterface
{
    public function __construct(RedisConfig $cfg)
    {
        if (!extension_loaded('redis')) {
            throw new \Mxs\Exceptions\Runtimes\PhpExtensionMissing('redis');
        }

        try {
            parent::__construct();
            /**
             * $redis->connect('127.0.0.1', 6379);
             * $redis->connect('127.0.0.1'); // port 6379 by default
             * $redis->connect('tls://127.0.0.1', 6379); // enable transport level security.
             * $redis->connect('tls://127.0.0.1'); // enable transport level security, port 6379 by default.
             * $redis->connect('127.0.0.1', 6379, 2.5); // 2.5 sec timeout.
             * $redis->connect('/tmp/redis.sock'); // unix domain socket.
             * $redis->connect('127.0.0.1', 6379, 1, '', 100); // 1 sec timeout, 100ms delay between reconnection attempts.
             * $redis->connect('/tmp/redis.sock', 0, 1.5, NULL, 0, 1.5); // Unix socket with 1.5s timeouts (connect and read)
             * 
             * //  With PhpRedis >= 5.3.0 you can specify authentication and stream information on connect
             * $redis->connect('127.0.0.1', 6379, 1, '', 0, 0, ['auth' => ['phpredis', 'phpredis']]);
             */
            if (empty($cfg->sock)) {
                $host_prefix = $cfg->transport_level ? 'tls://' : '';
                $this->connect($host_prefix . $cfg->host, $cfg->port);
            } else {
                $this->connect($cfg->sock);
            }
            if (!empty($cfg->auth)) {
                $this->auth($cfg->auth);
            }
            //  var_dump($ins->ping()); exit;
            $this->ping() or throw new ConnectServiceFailed('ping redis failed');
            $this->select($cfg->select);
        } catch (\RedisException $e) {
            throw new ConnectServiceFailed('Redis connnect failed', $e);
        }

    }
}
