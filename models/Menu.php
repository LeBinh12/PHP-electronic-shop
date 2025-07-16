<?php

require_once  './core/Models.php';

class Menu extends Model
{
    protected $table = 'menus';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'menu_name' => 'VARCHAR(255)',
        'menu_url' => 'VARCHAR(255)'
    ];
}
