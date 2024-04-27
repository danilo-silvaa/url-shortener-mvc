<?php

namespace App\Models;

use PDO;

class Database {
    private $conn;

    public function getConnection() {
        try {
            $path = __DIR__ . '/../../database/database.db';
            
            $this->conn = new PDO("sqlite:$path");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->createTables();
        } catch(PDOException $exception) {
            echo 'Erro ao conectar ao banco de dados: ' . $exception->getMessage();
        }
        return $this->conn;
    }

    private function createTables() {
        try {
            $sql = 'CREATE TABLE IF NOT EXISTS urls (
                        id TEXT PRIMARY KEY,
                        url TEXT
                    )';
            
            $this->conn->exec($sql);
        } catch(PDOException $exception) {
            echo 'Erro ao criar tabela: ' . $exception->getMessage();
        }
    }
}