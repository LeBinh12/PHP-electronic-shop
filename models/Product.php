<?php
require_once  './core/Models.php';


class Product extends Model
{
    protected $table = "products";

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255) NOT NULL',
        'price' => 'INT',
        'category_id' => 'INT',
        'content' => 'VARCHAR(255)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];
    protected $foreignKeys = [
        'category_id' => 'categories(id)'
    ];


    public function withCategory()
    {
        $stmt = $this->pdo->query("
            SELECT p.*, c.name as category_name
            FROM products p
            JOIN categories c ON p.category_id = c.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
