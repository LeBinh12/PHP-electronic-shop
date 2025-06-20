<?php
require_once  './core/Models.php';

class Category extends Model
{
    protected $table = "categories";

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255) NOT NULL',
        'status' => 'BIT',
        'icon' => 'VARCHAR(255)',
        'isDeleted' => 'BIT',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];
}
