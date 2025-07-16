<?php

require_once  './core/Models.php';

class RoleEmployee extends Model
{
    protected $table = 'role_employee';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'employee_id' => 'INT NOT NULL',
        'role_id' => 'INT NOT NULL'
    ];

    protected $foreignKeys = [
        'employee_id' => 'employees(id)',
        'role_id' => 'roles(id)'
    ];
}
