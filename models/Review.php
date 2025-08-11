<?php
require_once  './core/Models.php';

class Review extends Model
{
    protected $table = 'reviews';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'rating' => 'INT',
        'comment' => 'TEXT',
        'user_id' => 'INT',
        'product_id' => 'INT',
        'isDeleted' => 'TINYINT(1)',
    ];

    protected $foreignKeys = [
        'user_id' => 'users(id)',
        'product_id' => 'products(id)'
    ];
}
