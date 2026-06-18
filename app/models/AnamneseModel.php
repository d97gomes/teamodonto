<?php
require_once __DIR__ . '/../config/database.php';

class AnamneseModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /* ============================
       LISTAGEM GERAL (PAGINADA)
    ============================ */
    public function listarPaginado(int $limit, int $offset): array
    {
        $stmt = $this->db->prepare("
            SELECT
                a.id,
                a.data_registro,
                dp_p.nome AS paciente_nome,
                dp_d.nome AS dentista_nome
            FROM anamneses a
            JOIN paciente p ON p.id = a.paciente_id
            JOIN dados_pessoais dp_p ON dp_p.id = p.dados_pessoais_id
            JOIN dentista d ON d.id = a.dentista_id
            JOIN dados_pessoais dp_d ON dp_d.id = d.dados_pessoais_id
            ORDER BY a.data_registro DESC
            LIMIT ? OFFSET ?
        ");

        $stmt->bindValue(1, $limit, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contarTotal(): int
    {
        return (int) $this->db
            ->query("SELECT COUNT(*) FROM anamneses")
            ->fetchColumn();
    }

    /* ============================
       LISTAR POR PACIENTE
    ============================ */
    public function listarPorPaciente(int $pacienteId): array
    {
        $stmt = $this->db->prepare("
            SELECT
                a.id,
                a.data_registro,
                dp_d.nome AS dentista_nome
            FROM anamneses a
            JOIN dentista d ON d.id = a.dentista_id
            JOIN dados_pessoais dp_d ON dp_d.id = d.dados_pessoais_id
            WHERE a.paciente_id = ?
            ORDER BY a.data_registro DESC
        ");

        $stmt->execute([$pacienteId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================
       LISTAR POR DENTISTA
    ============================ */
    public function listarPorDentista(int $dentistaId): array
    {
        $stmt = $this->db->prepare("
            SELECT
                a.id,
                a.data_registro,
                dp_p.nome AS paciente_nome
            FROM anamneses a
            JOIN paciente p ON p.id = a.paciente_id
            JOIN dados_pessoais dp_p ON dp_p.id = p.dados_pessoais_id
            WHERE a.dentista_id = ?
            ORDER BY a.data_registro DESC
        ");

        $stmt->execute([$dentistaId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ============================
       BUSCAR POR ID
    ============================ */
    public function buscarPorId(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT * FROM anamneses WHERE id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ============================
       CRIAR
    ============================ */
    public function criar(array $dados): bool
{
    $stmt = $this->db->prepare("
        INSERT INTO anamneses (
            paciente_id,
            dentista_id,

            diabetes,
            hipertensao,
            problemas_cardiacos,
            problemas_respiratorios,
            doencas_infecciosas,
            doencas_osseas,
            cancer,
            disturbios_psicologicos,
            convulsoes,
            problemas_coagulacao,

            alergias,
            outras_doencas,

            em_tratamento_medico,
            medicamentos_em_uso,
            hospitalizado_ou_operado,
            detalhes_cirurgias,

            tabagista,
            tipo_tabaco,
            consumo_alcool,
            frequencia_alcool,

            escovacoes_por_dia,
            usa_fio_dental,
            bruxismo,
            apertamento,
            onicofagia,

            doencas_hereditarias,
            observacoes
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,
            ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?,
            ?, ?, ?, ?, ?,
            ?, ?
        )
    ");

    return $stmt->execute([
        $dados['paciente_id'],
        $dados['dentista_id'],

        $dados['diabetes'] ?? 0,
        $dados['hipertensao'] ?? 0,
        $dados['problemas_cardiacos'] ?? 0,
        $dados['problemas_respiratorios'] ?? 0,
        $dados['doencas_infecciosas'] ?? 0,
        $dados['doencas_osseas'] ?? 0,
        $dados['cancer'] ?? 0,
        $dados['disturbios_psicologicos'] ?? 0,
        $dados['convulsoes'] ?? 0,
        $dados['problemas_coagulacao'] ?? 0,

        $dados['alergias'] ?? null,
        $dados['outras_doencas'] ?? null,

        $dados['em_tratamento_medico'] ?? 0,
        $dados['medicamentos_em_uso'] ?? null,
        $dados['hospitalizado_ou_operado'] ?? 0,
        $dados['detalhes_cirurgias'] ?? null,

        $dados['tabagista'] ?? 0,
        $dados['tipo_tabaco'] ?? null,
        $dados['consumo_alcool'] ?? 0,
        $dados['frequencia_alcool'] ?? null,

        $dados['escovacoes_por_dia'] ?? 0,
        $dados['usa_fio_dental'] ?? 0,
        $dados['bruxismo'] ?? 0,
        $dados['apertamento'] ?? 0,
        $dados['onicofagia'] ?? 0,

        $dados['doencas_hereditarias'] ?? null,
        $dados['observacoes'] ?? null
    ]);
}
    /* ============================
       ATUALIZAR
    ============================ */
    public function atualizar(int $id, array $dados): bool
    {
        $stmt = $this->db->prepare("
            UPDATE anamneses SET
                diabetes = ?,
                hipertensao = ?,
                problemas_cardiacos = ?,
                problemas_respiratorios = ?,
                alergias = ?,
                medicamentos_em_uso = ?,
                observacoes = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $dados['diabetes'] ?? 0,
            $dados['hipertensao'] ?? 0,
            $dados['problemas_cardiacos'] ?? 0,
            $dados['problemas_respiratorios'] ?? 0,
            $dados['alergias'] ?? null,
            $dados['medicamentos_em_uso'] ?? null,
            $dados['observacoes'] ?? null,
            $id
        ]);
    }

    /* ============================
       EXCLUIR (FÍSICO)
    ============================ */
    public function excluir(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM anamneses WHERE id = ?
        ");
        return $stmt->execute([$id]);
    }

public function listarAlertasPorPaciente(int $pacienteId): array
{
    $stmt = $this->db->prepare("
        SELECT alerta FROM (
            SELECT alergias AS alerta
            FROM anamneses
            WHERE paciente_id = ?
              AND alergias IS NOT NULL
              AND alergias <> ''

            UNION ALL

            SELECT outras_doencas AS alerta
            FROM anamneses
            WHERE paciente_id = ?
              AND outras_doencas IS NOT NULL
              AND outras_doencas <> ''
        ) t
    ");

    $stmt->execute([$pacienteId, $pacienteId]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

}