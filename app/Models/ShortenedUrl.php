<?php

namespace App\Models;

use App\Models\Database;
use PDO;

class ShortenedUrl {
    private $conn;

    public function __construct()
    {
        $database = new Database();

        $this->conn = $database->getConnection();
    }
    
    public function index($id)
    {
        try {
           $stmt = $this->conn->prepare('SELECT url FROM urls WHERE id = ?');
           $stmt->execute([$id]);
           
           return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Erro ao buscar a URL: ' . $e->getMessage();
            exit();
        }
    }

    public function store($id, $url)
    {
        try {
            $stmt = $this->conn->prepare('INSERT INTO urls (id, url) VALUES (?, ?)');
            $stmt->bindParam(1, $id);
            $stmt->bindParam(2, $url);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Erro ao salvar a URL: ' . $e->getMessage();
            exit();
        }
    }
}