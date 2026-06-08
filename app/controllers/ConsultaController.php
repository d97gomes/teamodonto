<?php
require_once __DIR__ . '/../models/ConsultaModel.php';
require_once __DIR__ . '/../models/AgendaModel.php';
require_once __DIR__ . '/../models/AnamneseModel.php';

class ConsultaController
{
    private ConsultaModel $consultaModel;
    private AgendaModel $agendaModel;
    private AnamneseModel $anamneseModel;

    public function __construct()
    {
        $this->consultaModel = new ConsultaModel();
        $this->agendaModel   = new AgendaModel();
        $this->anamneseModel = new AnamneseModel();
    }

    /* ========= ABRIR CONSULTA ========= */
    public function abrir(int $agendaId): int|false
    {
        // Busca dados do agendamento
        $agenda = $this->agendaModel->buscarPorId($agendaId);

        if (!$agenda) {
            return false;
        }

        // Verifica se já existe consulta
        $consulta = $this->consultaModel->buscarPorAgenda($agendaId);

        if ($consulta) {
            return (int) $consulta['id'];
        }

        // Cria nova consulta
        return $this->consultaModel->criar(
            $agendaId,
            $agenda['paciente_id'],
            $agenda['dentista_id']
        );
    }

    /* ========= FINALIZAR CONSULTA ========= */
    public function finalizar(int $agendaId, string $evolucao): bool
    {
        $ok = $this->consultaModel->finalizar($agendaId, $evolucao);

        if (!$ok) {
            return false;
        }

        // Atualiza status da agenda
        return $this->agendaModel->atualizarStatus(
            $agendaId,
            'concluido'
        );
    }

    /* ========= BUSCAR CONSULTA POR AGENDA (EDITAR) ========= */
    public function buscarPorAgenda(int $agendaId): ?array
    {
        return $this->consultaModel->buscarPorAgenda($agendaId);
    }

    /* ========= ALERTAS DA ANAMNESE ========= */
    public function alertasAnamnese(int $agendaId): array
    {
        $agenda = $this->agendaModel->buscarPorId($agendaId);

        if (!$agenda) {
            return [];
        }

        return $this->anamneseModel
            ->listarAlertasPorPaciente($agenda['paciente_id']);
    }


}