<?php

require_once  './core/Models.php';

class RoleMenu extends Model
{
    protected $table = 'role_menu';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'menu_id' => 'INT NOT NULL',
        'role_id' => 'INT NOT NULL'
    ];

    protected $foreignKeys = [
        'menu_id' => 'menus(id)',
        'role_id' => 'roles(id)'
    ];
}
