<?php

require_once  './core/Models.php';

class Menu extends Model
{
    protected $table = 'menus';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'menu_name' => 'VARCHAR(255)',
        'menu_url' => 'VARCHAR(255)',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    

    public function getFilterMenus($keyword = null, $limit = 8, $offset = 0)
    {
        $sql = "SELECT * FROM menus WHERE isDeleted = 0";

        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND menu_name LIKE :keyword";
            $params['keyword'] = "%" . $keyword . "%";
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->bindValue(":limit", (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(":offset", (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countFilteredMenus($keyword)
    {
        $sql = "SELECT COUNT(*) as total FROM menus WHERE isDeleted = 0";
        $params = [];
        if (!empty($keyword)) {
            $sql .= " AND menu_name LIKE :keyword";
            $params['keyword'] = "%" . $keyword . "%";
        }

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue(":$key", $val);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
}
