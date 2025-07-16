<?php

require_once  './core/Models.php';

class EmployeeMenu extends Model
{
    protected $table = 'employee_menu';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'employee_id' => 'INT NOT NULL',
        'menu_id' => 'INT NOT NULL'
    ];

    protected $foreignKeys = [
        'employee_id' => 'employees(id)',
        'menu_id' => 'menus(id)'
    ];
}
