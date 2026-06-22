<?php

require_once __DIR__ . '/../config/database.php';

class Usuario {

    private PDO $conn;

    public function __construct() {
        $this->conn = Database::connect();
    }

    /* ========= BUSCAR POR EMAIL (LOGIN + RECUPERAR) ========= */
    public function buscarPorEmail(string $email): ?array
    {
        $sql = "
            SELECT * FROM usuario
            WHERE email = :email AND ativo = 1
            LIMIT 1
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /* ========= CADASTRO ========= */
    public function criar($nome, $email, $senha, $perfil): bool
    {
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
    public function emailExiste($email): bool
    {
        $sql = "SELECT id FROM usuario WHERE email = :email";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        return (bool) $stmt->fetch();
    }

    public function salvarTokenRecuperacao($email, $token): bool
{
    $sql = "
        UPDATE usuario
        SET reset_token = :token,
            reset_expira = DATE_ADD(NOW(), INTERVAL 1 HOUR)
        WHERE email = :email
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':token', $token);
    $stmt->bindValue(':email', $email);

    return $stmt->execute();
}

public function buscarPorToken($token): ?array
{
    $sql = "
        SELECT * FROM usuario
        WHERE reset_token = :token
          AND reset_expira > NOW()
        LIMIT 1
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':token', $token);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

/* ========= ATUALIZAR SENHA ✅ ========= */
public function atualizarSenha($id, $senha): bool
{
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "
        UPDATE usuario
        SET senha_hash = :senha,
            reset_token = NULL,
            reset_expira = NULL
        WHERE id = :id
    ";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':senha', $senhaHash);
    $stmt->bindValue(':id', $id);

    return $stmt->execute();
}
}