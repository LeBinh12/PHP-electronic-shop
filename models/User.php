<?php
require_once  './core/Models.php';

class User extends Model
{

    protected $table = "users";

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'FullName' => 'VARCHAR(255) NOT NULL',
        'Email' => 'VARCHAR(255) UNIQUE',
        'Phone' => 'VARCHAR(20)',
        'Address' => 'TEXT',
        'PasswordHash' => 'VARCHAR(255)',
        'CreatedAt' => 'DATETIME',
        'UpdateAt' => 'DATETIME',
        'deleted_by_id' => 'INT',
        'deleted_by_type ' => 'VARCHAR(50)',
        'deleted_at' => 'DATETIME',
        'reason' => 'TEXT',
        'isDeleted' => 'TINYINT(1)',
    ];

    public function getFilteredUsers($limit = 8, $offset = 0, $keyword = '')
    {
        $sql = "SELECT * FROM {$this->table} Where isDeleted = 0";

        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND FullName LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY id DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val, PDO::PARAM_STR);
        }

        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUser($keyword = '')
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE isDeleted = 0";
        $params = [];

        if (!empty($keyword)) {
            $sql .= " AND FullName LIKE :keyword";
            $params[':keyword'] = '%' . $keyword . '%';
        }

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val, PDO::PARAM_STR);
        }

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) ($result['total'] ?? 0);
    }

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
