<?php
require_once __DIR__ . '/../config/database.php';

class DentistaModel {

    private PDO $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /* ==========================
       LISTAR TODOS
    ========================== */
    public function listarTodos(): array {
        $sql = "
            SELECT
                d.id,
                dp.nome,
                dp.cpf,
                dp.sexo,
                dp.telefone,
                d.cro,
                d.especialidade
            FROM dentista d
            JOIN dados_pessoais dp ON dp.id = d.dados_pessoais_id
            WHERE d.ativo = 1
            ORDER BY dp.nome
        ";

        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ==========================
       CREATE COMPLETO
    ========================== */
    public function criarDentistaCompleto(array $dados): bool {
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

            // DADOS PESSOAIS (COM SEXO ✅)
            $stmt = $this->db->prepare("
                INSERT INTO dados_pessoais
                (nome, cpf, sexo, telefone, email, endereco_id)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $dados['nome'],
                $dados['cpf'],
                $dados['sexo'],
                $dados['telefone'] ?? null,
                $dados['email'] ?? null,
                $enderecoId
            ]);
            $dadosPessoaisId = $this->db->lastInsertId();

            // DENTISTA
            $stmt = $this->db->prepare("
                INSERT INTO dentista
                (dados_pessoais_id, cro, especialidade)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([
                $dadosPessoaisId,
                $dados['cro'],
                $dados['especialidade']
            ]);

            $this->db->commit();
            return true;

        } catch (Throwable $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /* ==========================
       BUSCAR POR ID (COM ENDEREÇO ✅)
    ========================== */
    public function buscarPorId(int $id): array|false {
        $sql = "
            SELECT
                d.id,
                dp.nome,
                dp.cpf,
                dp.sexo,
                dp.telefone,
                dp.email,

                e.cep,
                e.logradouro,
                e.numero,
                e.complemento,
                e.bairro,
                e.cidade,
                e.estado,

                d.cro,
                d.especialidade
            FROM dentista d
            JOIN dados_pessoais dp ON dp.id = d.dados_pessoais_id
            JOIN endereco e ON e.id = dp.endereco_id
            WHERE d.id = ? AND d.ativo = 1
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ==========================
       UPDATE COMPLETO (COM ENDEREÇO ✅)
    ========================== */
    public function atualizarDentistaCompleto(int $id, array $dados): bool {
        try {
            $this->db->beginTransaction();

            // ENDEREÇO
            $stmt = $this->db->prepare("
                UPDATE endereco e
                JOIN dados_pessoais dp ON dp.endereco_id = e.id
                JOIN dentista d ON d.dados_pessoais_id = dp.id
                SET
                    e.cep = ?,
                    e.logradouro = ?,
                    e.numero = ?,
                    e.complemento = ?,
                    e.bairro = ?,
                    e.cidade = ?,
                    e.estado = ?
                WHERE d.id = ?
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

            // DADOS PESSOAIS
            $stmt = $this->db->prepare("
                UPDATE dados_pessoais dp
                JOIN dentista d ON d.dados_pessoais_id = dp.id
                SET
                    dp.nome = ?,
                    dp.cpf = ?,
                    dp.sexo = ?,
                    dp.telefone = ?,
                    dp.email = ?
                WHERE d.id = ?
            ");
            $stmt->execute([
                $dados['nome'],
                $dados['cpf'],
                $dados['sexo'],
                $dados['telefone'] ?? null,
                $dados['email'] ?? null,
                $id
            ]);

            // DENTISTA
            $stmt = $this->db->prepare("
                UPDATE dentista
                SET
                    cro = ?,
                    especialidade = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $dados['cro'],
                $dados['especialidade'],
                $id
            ]);

            $this->db->commit();
            return true;

        } catch (Throwable $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /* ==========================
       DELETE LÓGICO
    ========================== */
    public function excluirDentista(int $id): bool {
        try {
            $stmt = $this->db->prepare(
                "UPDATE dentista SET ativo = 0 WHERE id = ?"
            );
            return $stmt->execute([$id]);

        } catch (Throwable $e) {
            return false;
        }
    }

    public function buscarPorNomeOuCro(string $termo): array
{
    $stmt = $this->db->prepare("
        SELECT d.id, dp.nome, d.cro
        FROM dentista d
        JOIN dados_pessoais dp ON dp.id = d.dados_pessoais_id
        WHERE dp.nome LIKE ? OR d.cro LIKE ?
        ORDER BY dp.nome
        LIMIT 10
    ");

    $like = "%{$termo}%";
    $stmt->execute([$like, $like]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}