<?php

require_once __DIR__ . '/../config/database.php';

class Usuario {

    private $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    /* ========= LOGIN ========= */
    public function buscarPorEmail($email) {
        $sql = "SELECT * FROM usuario WHERE email = :email AND ativo = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch();
    }

    /* ========= CADASTRO ========= */
    public function criar($nome, $email, $senha, $perfil) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $sql = "
            INSERT INTO usuario (nome, email, senha_hash, perfil)
            VALUES (:nome, :email, :senha_hash, :perfil)
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':senha_hash', $senhaHash);
        $stmt->bindValue(':perfil', $perfil);

        return $stmt->execute();
    }

    /* ========= VALIDAR EMAIL ========= */
    public function emailExiste($email) {
        $sql = "SELECT id FROM usuario WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return (bool) $stmt->fetch();
    }
}