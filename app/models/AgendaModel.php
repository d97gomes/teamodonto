<?php
require_once __DIR__ . '/../config/Database.php';

class AgendaModel
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /* ========= CREATE ========= */
    public function criar(array $dados): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO agenda (
                paciente_id,
                dentista_id,
                data,
                hora,
                status
            )
            VALUES (?, ?, ?, ?, 'pendente')
        ");

        return $stmt->execute([
            $dados['paciente_id'],
            $dados['dentista_id'],
            $dados['data'],
            $dados['hora']
        ]);
    }

    /* ========= READ SIMPLES (POR DATA) ========= */
    public function listarPorData(string $data): array
    {
        $stmt = $this->db->prepare("
            SELECT 
                a.id,
                a.data,
                a.hora,
                a.status,
                dp_p.nome AS paciente_nome,
                dp_d.nome AS dentista_nome
            FROM agenda a
            JOIN paciente p ON p.id = a.paciente_id
            LEFT JOIN dados_pessoais dp_p 
                ON dp_p.id = p.dados_pessoais_id
            JOIN dentista d ON d.id = a.dentista_id
            LEFT JOIN dados_pessoais dp_d 
                ON dp_d.id = d.dados_pessoais_id
            WHERE a.data = ?
            ORDER BY a.hora
        ");

        $stmt->execute([$data]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ========= READ AVANÇADO (DIA / SEMANA / MÊS) ========= */
    public function listar(string $tipo, string $data): array
    {
        $baseSql = "
            SELECT 
                a.id,
                a.data,
                a.hora,
                a.status,
                dp_p.nome AS paciente_nome,
                dp_d.nome AS dentista_nome
            FROM agenda a
            JOIN paciente p ON p.id = a.paciente_id
            LEFT JOIN dados_pessoais dp_p 
                ON dp_p.id = p.dados_pessoais_id
            JOIN dentista d ON d.id = a.dentista_id
            LEFT JOIN dados_pessoais dp_d 
                ON dp_d.id = d.dados_pessoais_id
        ";

        if ($tipo === 'dia') {
            $sql = $baseSql . " WHERE a.data = ? ORDER BY a.hora";
            $params = [$data];
        }

        if ($tipo === 'semana') {
            $sql = $baseSql . "
                WHERE YEARWEEK(a.data, 1) = YEARWEEK(?, 1)
                ORDER BY a.data, a.hora
            ";
            $params = [$data];
        }

        if ($tipo === 'mes') {
            $sql = $baseSql . "
                WHERE YEAR(a.data) = YEAR(?)
                  AND MONTH(a.data) = MONTH(?)
                ORDER BY a.data, a.hora
            ";
            $params = [$data, $data];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /* ========= UPDATE STATUS ========= */
    public function atualizarStatus(int $id, string $status): bool
    {
        $stmt = $this->db->prepare("
            UPDATE agenda SET status = ? WHERE id = ?
        ");
        return $stmt->execute([$status, $id]);
    }
}