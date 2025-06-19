<?php

require_once  './core/Models.php';

class Shipping extends Model
{
    protected $table = 'shipping';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'address' => 'TEXT',
        'method' => 'VARCHAR(50)',
        'status' => 'VARCHAR(50)',
        'shipping_at' => 'DATETIME'
    ];
}
