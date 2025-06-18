<?php
require_once  './core/Models.php';
class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'quantity' => 'INT',
        'unit_price' => 'DECIMAL(12,2)',
        'product_id' => 'INT',
        'order_id' => 'INT',
    ];

    protected $foreignKeys = [
        'product_id' => 'products(id)',
        'order_id' => 'orders(id)'
    ];
}
