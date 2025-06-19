<?php
require_once  './core/Models.php';

class Admin extends Model
{
    protected $table = 'admin';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'username' => 'VARCHAR(100)',
        'password_hash' => 'VARCHAR(255)',
        'email' => 'VARCHAR(255)',
        'role' => 'VARCHAR(255)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];
}
