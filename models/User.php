<?php
require_once  './core/Models.php';

class User extends Model
{

    protected $table = "users";

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'FullName' => 'VARCHAR(255) NOT NULL',
        'Email' => 'VARCHAR(255) UNIQUE',
        'Phone' => 'VARCHAR(20)',
        'Address' => 'TEXT',
        'PasswordHash' => 'VARCHAR(255)',
        'CreatedAt' => 'DATETIME'
    ];
}
