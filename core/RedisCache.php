<?php

use Predis\Client;

class RedisCache
{
    private static $client = null;

    public static function getClient()
    {
        if (self::$client == null) {
            self::$client = new Client([
                'scheme' => 'tcp',
                'host' => '127.0.0.1',
                'port' => 6379,
            ]);
        }
        return self::$client;
    }

    public static function get($key)
    {
        return self::getClient()->get($key);
    }

    public static function set($key, $value, $ttl = 600)
    {
        return self::getClient()->setex($key, $ttl, $value);
    }

    public static function delete($key)
    {
        return self::getClient()->del([$key]);
    }

    public static function exists($key)
    {
        return self::getClient()->exists($key);
    }

    public static function keys($pattern)
    {
        return self::getClient()->keys($pattern);
    }
}
