<?php
require_once __DIR__ . '/../config/database.php';

class ProcedimentoModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function listar(): array
    {
        return $this->db
            ->query("SELECT * FROM procedimentos WHERE ativo = 1 ORDER BY nome")
            ->fetchAll(PDO::FETCH_ASSOC);
    }

    public function criar(array $dados): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO procedimentos (nome, descricao, valor)
            VALUES (?, ?, ?)
        ");

        return $stmt->execute([
            $dados['nome'],
            $dados['descricao'] ?? null,
            $dados['valor']
        ]);
    }

    public function buscarPorId(int $id): array|false
{
    $stmt = $this->db->prepare(
        "SELECT * FROM procedimentos WHERE id = ?"
    );
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function atualizar(int $id, array $dados): bool
{
    $stmt = $this->db->prepare("
        UPDATE procedimentos SET
            nome = ?,
            descricao = ?,
            valor = ?
        WHERE id = ?
    ");

    return $stmt->execute([
        $dados['nome'],
        $dados['descricao'] ?? null,
        $dados['valor'],
        $id
    ]);
}

public function excluir(int $id): bool
{
    $stmt = $this->db->prepare(
        "UPDATE procedimentos SET ativo = 0 WHERE id = ?"
    );
    return $stmt->execute([$id]);
}
}