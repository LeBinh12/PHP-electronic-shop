 <?php
    require_once  './core/Models.php';

    class Inventory extends Model
    {
        protected $table = 'inventory';
        protected $fields = [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'stock_quantity' => 'INT',
            'last_update' => 'DATETIME',
            'product_id' => 'INT',
            'isDeleted' => 'TINYINT(1)',
        ];

        protected $foreignKeys = [
            'product_id' => 'products(id)'
        ];

        public function getInventoryProduct($id)
        {
            $stmt = $this->pdo->prepare("
        SELECT * FROM inventory WHERE product_id = :id AND isDeleted = 0
    ");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
