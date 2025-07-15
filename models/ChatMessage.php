<?php

require_once  './core/Models.php';

class ChatMessage extends Model
{
    protected $table = "chat_messages";

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'user_id' => 'INT NOT NULL',
        'sender_id' => 'INT NOT NULL',
        'sender_role' => 'VARCHAR(50) NOT NULL',
        'message' => 'TEXT',
        'created_at' => 'DATETIME DEFAULT CURRENT_TIMESTAMP',
        'isDeleted' => 'TINYINT(1)'
    ];


    protected $foreignKeys = [
        'user_id' => 'users(id)'
    ];
}
