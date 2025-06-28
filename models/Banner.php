<?php

require_once  './core/Models.php';


class Banner extends Model
{
    protected $table = 'banners';

    protected $fields = [
        'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
        'image' => 'VARCHAR(255)',
        'status' => 'BIT',
        'isDeleted' => 'TINYINT(1)',
    ];
}
