<?php
require_once __DIR__ . '/../config/database.php';

class PacienteModel {

    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

public function listarTodos(): array {
    $sql = "
        SELECT 
            p.id,
            d.nome,
            d.cpf,
            d.telefone,
            e.cidade,
            e.estado
        FROM paciente p
        JOIN dados_pessoais d ON d.id = p.dados_pessoais_id
        JOIN endereco e ON e.id = d.endereco_id
        WHERE p.ativo = 1
        ORDER BY d.nome
    ";

    return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

    public function criarPacienteCompleto(array $dados): bool {
        try {
            $this->db->beginTransaction();

            // ENDEREÇO
            $stmt = $this->db->prepare("
                INSERT INTO endereco
                (cep, logradouro, numero, complemento, bairro, cidade, estado)
                VALUES (?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $dados['cep'] ?? null,
                $dados['logradouro'],
                $dados['numero'] ?? null,
                $dados['complemento'] ?? null,
                $dados['bairro'],
                $dados['cidade'],
                $dados['estado']
            ]);
            $enderecoId = $this->db->lastInsertId();

            // DADOS PESSOAIS
            $stmt = $this->db->prepare("
                INSERT INTO dados_pessoais
                (nome, cpf, telefone, email, data_nascimento, endereco_id)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $dados['nome'],
                $dados['cpf'],
                $dados['telefone'] ?? null,
                $dados['email'] ?? null,
                $dados['data_nascimento'] ?? null,
                $enderecoId
            ]);
            $dadosPessoaisId = $this->db->lastInsertId();

            // PACIENTE
            $stmt = $this->db->prepare("
                INSERT INTO paciente (dados_pessoais_id)
                VALUES (?)
            ");
            $stmt->execute([$dadosPessoaisId]);

            $this->db->commit();
            return true;

        } catch (Throwable $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function excluirPaciente(int $id): bool
{
    try {
        $stmt = $this->db->prepare(
            "UPDATE paciente SET ativo = 0 WHERE id = ?"
        );
        return $stmt->execute([$id]);

    } catch (Throwable $e) {
        return false;
    }
}

public function buscarPorId(int $id): array|false
{
    $sql = "
        SELECT
            p.id,
            d.nome,
            d.cpf,
            d.telefone,
            d.email,
            d.data_nascimento,
            e.cep,
            e.logradouro,
            e.numero,
            e.complemento,
            e.bairro,
            e.cidade,
            e.estado
        FROM paciente p
        JOIN dados_pessoais d ON d.id = p.dados_pessoais_id
        JOIN endereco e ON e.id = d.endereco_id
        WHERE p.id = ? AND p.ativo = 1
        LIMIT 1
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function atualizarPacienteCompleto(int $id, array $dados): bool
{
    try {
        $this->db->beginTransaction();

        // Atualiza ENDEREÇO
        $stmt = $this->db->prepare("
            UPDATE endereco e
            JOIN dados_pessoais d ON d.endereco_id = e.id
            JOIN paciente p ON p.dados_pessoais_id = d.id
            SET
                e.cep = ?,
                e.logradouro = ?,
                e.numero = ?,
                e.complemento = ?,
                e.bairro = ?,
                e.cidade = ?,
                e.estado = ?
            WHERE p.id = ?
        ");
        $stmt->execute([
            $dados['cep'] ?? null,
            $dados['logradouro'],
            $dados['numero'] ?? null,
            $dados['complemento'] ?? null,
            $dados['bairro'],
            $dados['cidade'],
            $dados['estado'],
            $id
        ]);

        // Atualiza DADOS PESSOAIS
        $stmt = $this->db->prepare("
            UPDATE dados_pessoais d
            JOIN paciente p ON p.dados_pessoais_id = d.id
            SET
                d.nome = ?,
                d.cpf = ?,
                d.telefone = ?,
                d.email = ?,
                d.data_nascimento = ?
            WHERE p.id = ?
        ");
        $stmt->execute([
            $dados['nome'],
            $dados['cpf'],
            $dados['telefone'] ?? null,
            $dados['email'] ?? null,
            $dados['data_nascimento'] ?? null,
            $id
        ]);

        $this->db->commit();
        return true;

    } catch (Throwable $e) {
        $this->db->rollBack();
        return false;
    }
}

}