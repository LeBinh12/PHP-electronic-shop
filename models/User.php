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
        'CreatedAt' => 'DATETIME'
    ];

    public function findByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE Email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
