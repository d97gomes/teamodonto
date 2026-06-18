<?php
require_once __DIR__ . '/../config/Database.php';

class ConsultaModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /* ========= CREATE (ABRIR CONSULTA) ========= */
    public function criar(
        int $agendaId,
        int $pacienteId,
        int $dentistaId
    ): int|false {
        $stmt = $this->db->prepare("
            INSERT INTO consultas (
                agenda_id,
                paciente_id,
                dentista_id,
                data_inicio,
                status
            )
            VALUES (?, ?, ?, NOW(), 'em_atendimento')
        ");

        $ok = $stmt->execute([
            $agendaId,
            $pacienteId,
            $dentistaId
        ]);

        return $ok ? (int) $this->db->lastInsertId() : false;
    }

    /* ========= READ (POR AGENDA) ========= */
    public function buscarPorAgenda(int $agendaId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM consultas
            WHERE agenda_id = ?
            LIMIT 1
        ");

        $stmt->execute([$agendaId]);
        $consulta = $stmt->fetch(PDO::FETCH_ASSOC);

        return $consulta ?: null;
    }

    /* ========= UPDATE (FINALIZAR CONSULTA) ========= */
    public function finalizar(
        int $agendaId,
        string $evolucao
    ): bool {
        $stmt = $this->db->prepare("
            UPDATE consultas
            SET evolucao = ?,
                data_fim = NOW(),
                status = 'finalizada'
            WHERE agenda_id = ?
              AND status = 'em_atendimento'
        ");

        return $stmt->execute([
            $evolucao,
            $agendaId
        ]);
    }

    public function listar(): array
{
    $stmt = $this->db->query("
        SELECT
            c.id,
            c.agenda_id,
            c.status,
            c.data_inicio,
            c.data_fim,
            p.nome AS paciente_nome,
            d.nome AS dentista_nome
        FROM consultas c
        JOIN agenda a ON a.id = c.agenda_id
        JOIN paciente p ON p.id = c.paciente_id
        JOIN dentista d ON d.id = c.dentista_id
        ORDER BY c.data_inicio DESC
    ");

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/* ========= READ (POR ID) ========= */
/* ========= READ (POR ID) ========= */
public function buscarPorId(int $id): ?array
{
    $stmt = $this->db->prepare("
        SELECT 
            c.*,

            dp_p.nome AS paciente,
            dp_d.nome AS dentista

        FROM consultas c

        JOIN paciente p ON p.id = c.paciente_id
        JOIN dados_pessoais dp_p ON dp_p.id = p.dados_pessoais_id

        JOIN dentista d ON d.id = c.dentista_id
        JOIN dados_pessoais dp_d ON dp_d.id = d.dados_pessoais_id

        WHERE c.id = ?  -- ✅ CORRETO
    ");

    $stmt->execute([$id]);

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}


}
