<?php
require_once  './core/Models.php';

class Category extends Model
{
    protected $table = "categories";

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255) NOT NULL',
        'status' => 'TINYINT(1)',
        'icon' => 'VARCHAR(255)',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    public function getFilteredCategories($limit = 8, $offset = 0, $keyword = '')
    {
        $sql = "SELECT * FROM {$this->table} WHERE isDeleted = 0";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND name LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);

        // Bind keyword nếu có
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val, PDO::PARAM_STR);
        }

        // Bind limit và offset
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function countCategory()
    {
        $sql = "
        SELECT COUNT(*) as total
        FROM categories c
        WHERE c.isDeleted = 0
    ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
