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

        public function getFiltered($keyword = '', int $limit = 8, int $offset = 0)
        {
            $sql = "
        SELECT inv.*, p.name AS product_name
        FROM {$this->table} inv
        JOIN products p ON p.id = inv.product_id
        WHERE inv.isDeleted = 0
    ";

            $params = [];

            if ($keyword !== '') {
                $sql            .= " AND p.name LIKE :kw";
                $params['kw']    = '%' . $keyword . '%';
            }

            $sql .= " ORDER BY inv.id DESC LIMIT :limit OFFSET :offset";

            $stmt = $this->pdo->prepare($sql);
            foreach ($params as $k => $v) {
                $stmt->bindValue(':' . $k, $v);
            }
            $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function countFiltered($keyword = '')
        {
            $sql = "
        SELECT COUNT(*) AS total
        FROM {$this->table} inv
        JOIN products p ON p.id = inv.product_id
        WHERE inv.isDeleted = 0
    ";
            $params = [];
            if ($keyword !== '') {
                $sql           .= " AND p.name LIKE :kw";
                $params['kw']   = '%' . $keyword . '%';
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        }

        public function getInventoryProduct($id)
        {
            $stmt = $this->pdo->prepare("
        SELECT * FROM inventory WHERE product_id = :id AND isDeleted = 0
    ");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
