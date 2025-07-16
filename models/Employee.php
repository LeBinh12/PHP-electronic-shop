<?php

require_once  './core/Models.php';


class Employee extends Model
{
    protected $table = 'employees';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255)',
        'phone' => 'VARCHAR(20)',
        'email' => 'VARCHAR(255) UNIQUE NOT NULL',
        'position' => 'VARCHAR(255)',
        'address' => 'VARCHAR(255)',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];
}
