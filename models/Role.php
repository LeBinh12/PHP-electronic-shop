<?php

require_once  './core/Models.php';

class Role extends Model
{
    protected $table = 'roles';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'role_name' => 'VARCHAR(255)',
    ];
}
