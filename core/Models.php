<?php
require_once './config/database.php';

abstract class Model
{
    protected $pdo;
    protected $table;
    protected $fields = [];
    protected $foreignKeys = [];

    public function __construct()
    {
        $this->pdo = Database::getInstance();
        $this->setTableName();
    }

    protected function setTableName()
    {
        if (!$this->table) {
            $this->table = strtolower(get_class($this)) . "s";
        }
    }

    public function createTable()
    {
        // kiểm tra bảng có tồn tại chưa
        $stmt = $this->pdo->prepare("SHOW TABLES LIKE :table");
        $stmt->execute(['table' => $this->table]);
        $tableExists = $stmt->fetch();

        if (!$tableExists) {
            // Nếu bảng chưa tồn tại thì tạo mới hoàn toàn

            $columns = [];

            foreach ($this->fields as $name => $type) {
                $columns[] = "$name $type";
            }

            if (!empty($this->foreignKeys)) {
                foreach ($this->foreignKeys as $col => $ref) {
                    $columns[] = "FOREIGN KEY ($col) REFERENCES $ref";
                }
            }


            $columns_sql = implode(", ", $columns);
            $sql = "CREATE TABLE {$this->table} ({$columns_sql})";
            $this->pdo->exec($sql);
        } else {
            // Nếu bảng đã có thì kiểm tra và thêm cột mới
            $stmt = $this->pdo->query("DESCRIBE {$this->table}");
            $existingColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($this->fields as $name => $type) {
                if (!in_array($name, $existingColumns)) {
                    $sql = "ALTER TABLE {$this->table} ADD COLUMN {$name} {$type}";
                    $this->pdo->exec($sql);
                    echo "Added column {$name} to table {$this->table}.<br>";
                }
            }
        }
    }


    public function all()
    {
        $stmt = $this->pdo->query("SELECT * FROM {$this->table}");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data): mixed
    {
        $columns = implode(",", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} ($columns) VALUES ($values)");
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }
}
