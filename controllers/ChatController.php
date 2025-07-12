<?php

require_once './core/RedisCache.php';

class ChatController
{
    public function sendMessage($userId, $from, $message)
    {
        $chatKey = "chat:user:$userId";

        $entry = json_encode([
            'from' => $from,
            'message' => $message,
            'time' => date('H:i d/m/Y'),
        ]);

        RedisCache::getClient()->rpush($chatKey, [$entry]);
    }

    public function getChatHistory($userId)
    {
        $chatKey = "chat:user:$userId";

        $messages = RedisCache::getClient()->lrange($chatKey, 0, -1);
        return array_map('json_decode', $messages);
    }

    public function clearChat($userId)
    {
        $chatKey = "chat:user:$userId";
        RedisCache::delete($chatKey);
    }
}
