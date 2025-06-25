<?php
require_once  './core/Models.php';

class Order extends Model
{
    protected $table = "orders";
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'total_amount' => 'DECIMAL(12,2)',
        'status' => 'VARCHAR(50)',
        'payment_id' => 'INT',
        'shipping_id' => 'INT',
        'user_id' => 'INT',
        'note' => 'TEXT',
        'create_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    protected $foreignKeys = [
        'user_id' => 'users(id)',
        'shipping_id' => 'shipping(id)',
        'payment_id' => 'payments(id)'
    ];
}
