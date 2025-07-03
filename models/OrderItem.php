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

    public function getOrderItemByOrderId($orderId)
    {
        $sql = "
        SELECT 
            *
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = :order_id
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
