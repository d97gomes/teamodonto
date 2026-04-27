<?php

require_once __DIR__ . '/../config/database.php';

class Usuario {

    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuario WHERE email = :email AND ativo = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch();
    }
}