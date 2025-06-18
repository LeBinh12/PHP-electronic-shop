 <?php
    require_once  './core/Models.php';

    class Inventory extends Model
    {
        protected $table = 'inventory';
        protected $fields = [
            'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
            'stock_quantity' => 'INT',
            'last_update' => 'DATETIME',
            'product_id' => 'INT'
        ];

        protected $foreignKeys = [
            'product_id' => 'products(id)'
        ];
    }
