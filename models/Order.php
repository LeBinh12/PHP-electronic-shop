<?php
require_once  './core/Models.php';

class Order extends Model
{
    protected $table = "orders";
    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'code' => 'VARCHAR(50) NOT NULL',
        'total_amount' => 'DECIMAL(12,2)',
        'status_id' => 'INT',
        'payment_id' => 'INT',
        'shipping_id' => 'INT',
        'user_id' => 'INT',
        'note' => 'TEXT',
        'create_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        'isDeleted' => 'TINYINT(1)',
    ];

    protected $foreignKeys = [
        'user_id' => 'users(id)',
        'shipping_id' => 'shipping(id)',
        'payment_id' => 'payments(id)',
        'status_id' => 'status(id)'
    ];

    public function findByCode($code)
    {
        $sql = "
            SELECT  o.*, u.* ,s.name AS status_name, o.id AS order_id
            FROM    orders o
            JOIN    status s   ON o.status_id = s.id
            JOIN    users u ON o.user_id = u.id
            WHERE   o.code  = :code
              AND   o.isDeleted = 0
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['code' => $code]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findOrders(
        int $userId,
        ?int $statusId = null,
        string $keyword    = '',
        int    $limit      = 10,
        int    $offset     = 0
    ) {
        $sql = "
            SELECT  o.*, u.* ,s.name AS status_name, o.id AS order_id
            FROM    orders o
            JOIN    status s   ON o.status_id = s.id
            JOIN    users u ON o.user_id = u.id
            WHERE   o.user_id  = :user_id
              AND   o.isDeleted = 0
        ";

        $params = ['user_id' => $userId];

        if ($statusId !== null) {
            $sql .= " AND o.status_id = :status_id";
            $params['status_id'] = $statusId;
        }

        if ($keyword !== '') {
            $sql .= " AND o.code LIKE :kw";
            $params['kw'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY o.id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countOrders(int $userId, ?int $statusId = null, $keyword = ''): int
    {
        $sql = "SELECT COUNT(*) FROM orders WHERE user_id = :uid AND isDeleted = 0";
        $params = ['uid' => $userId];

        if ($statusId !== null) {
            $sql .= " AND status_id = :sid";
            $params['sid'] = $statusId;
        }
        if ($keyword !== '') {
            $sql .= " AND code LIKE :kw";
            $params['kw'] = '%' . $keyword . '%';
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function findAllOrders(
        string $keyword    = '',
        int    $limit      = 10,
        int    $offset     = 0
    ) {
        $sql = "
            SELECT  o.*, u.* ,s.name AS status_name, o.id AS order_id
            FROM    orders o
            JOIN    status s   ON o.status_id = s.id
            JOIN    users u ON o.user_id = u.id
            WHERE   o.isDeleted = 0
        ";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND o.code LIKE :kw";
            $params['kw'] = '%' . $keyword . '%';
        }

        $sql .= " ORDER BY o.id DESC LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);

        foreach ($params as $k => $v) {
            $stmt->bindValue(":$k", $v);
        }
        $stmt->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAllOrders($keyword = ""): int
    {
        $sql = "SELECT COUNT(*) FROM orders WHERE isDeleted = 0";
        $params = [];

        if ($keyword !== '') {
            $sql .= " AND code LIKE :kw";
            $params['kw'] = '%' . $keyword . '%';
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }
}
