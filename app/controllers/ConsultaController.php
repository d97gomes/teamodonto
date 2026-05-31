<?php

require_once __DIR__ . '/../models/ConsultaModel.php';
require_once __DIR__ . '/../models/AgendaModel.php';

class ConsultaController
{
    private ConsultaModel $consulta;
    private AgendaModel $agenda;

    public function __construct(PDO $pdo)
    {
        $this->consulta = new ConsultaModel($pdo);
        $this->agenda   = new AgendaModel($pdo);
    }

    public function showByAgenda(int $agendaId): array
    {
        $consulta = $this->consulta->buscarPorAgenda($agendaId);

        return $consulta ?: [];
    }

    public function store(): array
    {
        $dados = json_decode(file_get_contents("php://input"), true);

        if (empty($dados['agenda_id'])) {
            return [
                'success' => false,
                'message' => 'Agenda não informada'
            ];
        }

        $agenda = $this->agenda->buscarPorId((int) $dados['agenda_id']);

        if (!$agenda) {
            return [
                'success' => false,
                'message' => 'Agenda não encontrada'
            ];
        }

        $this->agenda->atualizarStatus(
            (int) $dados['agenda_id'],
            'em_atendimento'
        );

        return [
            'success' => $this->consulta->criar(
                (int) $dados['agenda_id']
            )
        ];
    }

    public function finalizar(): array
    {
        $dados = json_decode(file_get_contents("php://input"), true);

        if (
            empty($dados['consulta_id']) ||
            empty($dados['agenda_id'])
        ) {
            return [
                'success' => false,
                'message' => 'Dados inválidos'
            ];
        }

        $this->consulta->finalizar(
            (int) $dados['consulta_id'],
            $dados['evolucao'] ?? ''
        );

        $this->agenda->atualizarStatus(
            (int) $dados['agenda_id'],
            'concluida'
        );

        return ['success' => true];
    }
}