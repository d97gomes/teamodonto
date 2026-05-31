<?php

class ConsultaModel
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function criar(int $agendaId): bool
    {
        $sql = "INSERT INTO consulta (agenda_id, data_inicio)
                VALUES (?, NOW())";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$agendaId]);
    }

    public function buscarPorAgenda(int $agendaId): ?array
    {
        $sql = "SELECT * FROM consulta WHERE agenda_id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$agendaId]);

        return $stmt->fetch() ?: null;
    }

    public function finalizar(
        int $consultaId,
        string $evolucao
    ): bool {
        $sql = "UPDATE consulta
                SET evolucao = ?, data_fim = NOW(), status = 'finalizada'
                WHERE id = ?";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$evolucao, $consultaId]);
    }
}