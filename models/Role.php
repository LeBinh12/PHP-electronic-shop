<?php

require_once  './core/Models.php';

class Role extends Model
{
    protected $table = 'roles';
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'role_name' => 'VARCHAR(255)',
        'isDeleted' => 'TINYINT(1)',
        'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
    ];

    public function getFilterRoles($keyword = null, $limit = 8, $offset = 0)
    {
        $sql = "SELECT * FROM roles WHERE isDeleted = 0 ";

        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND role_name LIKE :keyword";
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

    public function countFilteredRoles($keyword)
    {
        $sql = "SELECT COUNT(*) as total FROM roles WHERE isDeleted = 0";
        $params = [];
        if (!empty($keyword)) {
            $sql .= " AND role_name LIKE :keyword";
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
