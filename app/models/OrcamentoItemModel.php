<?php
require_once __DIR__ . '/../config/database.php';

class OrcamentoItemModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Adiciona um item ao orçamento
     * O valor vem do procedimento
     */
    public function adicionar(
        int $orcamentoId,
        int $procedimentoId,
        int $dente,
        string $face
    ): bool {
        // 1️⃣ Buscar valor do procedimento
        $stmtProc = $this->db->prepare("
            SELECT valor
            FROM procedimentos
            WHERE id = ?
        ");
        $stmtProc->execute([$procedimentoId]);
        $procedimento = $stmtProc->fetch(PDO::FETCH_ASSOC);

        if (!$procedimento) {
            return false;
        }

        $valor = $procedimento['valor'];

        // 2️⃣ Inserir item
        $stmt = $this->db->prepare("
            INSERT INTO orcamento_itens
                (orcamento_id, procedimento_id, dente, face, valor)
            VALUES (?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $orcamentoId,
            $procedimentoId,
            $dente,
            $face,
            $valor
        ]);
    }

    /**
     * Lista itens de um orçamento
     */
    public function listarPorOrcamento(int $orcamentoId): array
    {
        $stmt = $this->db->prepare("
            SELECT
                oi.id,
                oi.dente,
                oi.face,
                oi.valor,
                p.nome AS procedimento
            FROM orcamento_itens oi
            JOIN procedimentos p ON p.id = oi.procedimento_id
            WHERE oi.orcamento_id = ?
        ");

        $stmt->execute([$orcamentoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Remove um item do orçamento
     */
    public function remover(int $itemId): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM orcamento_itens
            WHERE id = ?
        ");

        return $stmt->execute([$itemId]);
    }
}
