<?php
require_once  './core/Models.php';

class Supplier extends Model
{
    protected $table = 'suppliers';

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'name' => 'VARCHAR(255) NOT NULL',
        'contact_person' => 'VARCHAR(255)',
        'Phone' => 'VARCHAR(20)',
        'Email' => ' VARCHAR(255)',
        'Address' => 'TEXT',
        'isDeleted' => 'BIT',
    ];
}
