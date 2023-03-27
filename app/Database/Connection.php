<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    public static function make()
    {
        $config = config('database.connections.mysql');

        try {
            return new PDO(
                "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}",
                $config['username'],
                $config['password']
            );
        } catch (PDOException $e) {
            die('Cannot connect to the database: ' . $e->getMessage());
        }
    }
}
