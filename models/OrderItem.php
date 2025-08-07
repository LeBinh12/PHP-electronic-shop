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

    public function countProductsSoldThisWeek()
    {
        $sql = "SELECT SUM(oi.quantity) AS total_sold
        FROM {$this->table} oi JOIN orders o ON oi.order_id = o.id 
        WHERE o.isDeleted = 0 
                AND o.status_id = 6 
                AND YEARWEEK(o.create_at, 1) = YEARWEEK(CURDATE(), 1)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }

    public function getOrderItemByOrderId($orderId)
    {
        $sql = "
        SELECT 
            *
        FROM {$this->table} oi
        JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = :order_id
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function hasPendingOrCompletedOrdersByProduct($productId): bool
    {
        $sql = "
        SELECT 1
        FROM {$this->table} oi
        JOIN orders o ON oi.order_id = o.id
        WHERE oi.product_id = :pid
          AND o.isDeleted = 0
          AND o.status_id IN (1, 6)
        LIMIT 1
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['pid' => $productId]);
        return (bool) $stmt->fetchColumn();
    }

    public function getOrderIdsByProductId($productId): array
    {
        $sql = "
        SELECT DISTINCT od.order_id
        FROM {$this->table} od
        WHERE od.product_id = :product_id
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['product_id' => $productId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
