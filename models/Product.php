    <?php
    require_once  './core/Models.php';


    class Product extends Model
    {
        protected $table = "products";

        protected $fields = [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(255) NOT NULL',
            'price' => 'DECIMAL(12,2)',
            'discount' => 'DECIMAL(5,2)',
            'description' => 'TEXT',
            'image_url' => 'VARCHAR(500)',
            'category_id' => 'INT',
            'supplier_id' => 'INT',
            'isDeleted' => 'BIT',
            'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ];
        protected $foreignKeys = [
            'category_id' => 'categories(id)',
            'supplier_id' => 'suppliers(id)',
        ];


        // dưới đây là các hàm xử lý trực tiếp trên server
        public function getProductsByCategory($id)
        {
            $stmt = $this->pdo->query("
                SELECT p.*, c.name as category_name
                FROM products p
                JOIN categories c ON p.category_id = $:id
            ");
            $stmt->execute(['id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
