<?php
require_once __DIR__ . '/../config/database.php';

class OrcamentoModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Cria um novo orçamento (cabeçalho)
     */
    public function criar(int $pacienteId, int $dentistaId): int|false
    {
        $stmt = $this->db->prepare("
            INSERT INTO orcamentos (paciente_id, dentista_id)
            VALUES (?, ?)
        ");

        $ok = $stmt->execute([$pacienteId, $dentistaId]);

        return $ok ? (int) $this->db->lastInsertId() : false;
    }

    /**
     * Atualiza o valor total do orçamento
     */
    public function atualizarTotal(int $orcamentoId): void
    {
        $stmt = $this->db->prepare("
            UPDATE orcamentos
            SET valor_total = (
                SELECT IFNULL(SUM(valor), 0)
                FROM orcamento_itens
                WHERE orcamento_id = ?
            )
            WHERE id = ?
        ");

        $stmt->execute([$orcamentoId, $orcamentoId]);
    }

    /**
     * Busca orçamento simples por ID (uso interno)
     */
    public function buscarPorId(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM orcamentos
            WHERE id = ?
        ");

        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Lista orçamentos (para orcamento-list)
     */
    public function listar(): array
    {
        $stmt = $this->db->query("
            SELECT
                o.id,
                o.data_orcamento,
                o.status,
                o.valor_total,
                dp_p.nome AS paciente,
                dp_d.nome AS dentista
            FROM orcamentos o
            JOIN paciente p ON p.id = o.paciente_id
            JOIN dados_pessoais dp_p ON dp_p.id = p.dados_pessoais_id
            JOIN dentista d ON d.id = o.dentista_id
            JOIN dados_pessoais dp_d ON dp_d.id = d.dados_pessoais_id
            ORDER BY o.data_orcamento DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca dados completos para o formulário (EDITAR)
     * ✅ MÉTODO PRINCIPAL DO NOVO PADRÃO
     */
public function buscarParaFormulario(int $id): array|false
{
    $stmt = $this->db->prepare("
        SELECT
            o.id,
            o.paciente_id,
            o.dentista_id,
            o.status,
            o.valor_total,
            dp_p.nome AS paciente,
            dp_d.nome AS dentista
        FROM orcamentos o
        JOIN paciente p ON p.id = o.paciente_id
        JOIN dados_pessoais dp_p ON dp_p.id = p.dados_pessoais_id
        JOIN dentista d ON d.id = o.dentista_id
        JOIN dados_pessoais dp_d ON dp_d.id = d.dados_pessoais_id
        WHERE o.id = ?
    ");

    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    /**
     * Atualiza status do orçamento
     */
    public function atualizarStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("
            UPDATE orcamentos
            SET status = ?
            WHERE id = ?
        ");

        return $stmt->execute([$status, $id]);
    }

    /**
     * Exclui orçamento
     */
    public function excluir(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM orcamentos
            WHERE id = ?
        ");

        return $stmt->execute([$id]);
    }

    
}