<?php
require_once __DIR__ . '/../models/AgendaModel.php';

class AgendaController
{
    private AgendaModel $model;

    public function __construct()
    {
        $this->model = new AgendaModel();
    }

    /* ========= CREATE ========= */
    public function store(): array
    {
        // ✅ LÊ FORM DATA CORRETAMENTE
        $pacienteId = $_POST['paciente_id'] ?? null;
        $dentistaId = $_POST['dentista_id'] ?? null;
        $data       = $_POST['data_agenda'] ?? null;
        $hora       = $_POST['hora_agenda'] ?? null;

        if (!$pacienteId || !$dentistaId || !$data || !$hora) {
            return [
                'success' => false,
                'message' => 'Selecione paciente, dentista, data e hora.'
            ];
        }

        $ok = $this->model->criar([
            'paciente_id' => (int) $pacienteId,
            'dentista_id' => (int) $dentistaId,
            'data'        => $data,
            'hora'        => $hora
        ]);

        return [
            'success' => $ok
        ];
    }

    /* ========= READ ========= */
    public function index(): array
    {
        $tipo = $_GET['tipo'] ?? 'dia';
        $data = $_GET['data'] ?? date('Y-m-d');

        return [
            'success' => true,
            'data' => $this->model->listar($tipo, $data)
        ];
    }

    /* ========= UPDATE STATUS ========= */
    public function updateStatus(): array
    {
        // ✅ AQUI SIM É JSON
        $dados = json_decode(file_get_contents('php://input'), true);

        if (
            empty($dados['id']) ||
            empty($dados['status'])
        ) {
            return [
                'success' => false,
                'message' => 'Dados inválidos'
            ];
        }

        $statusPermitidos = [
            'confirmado',
            'em_atendimento',
            'concluido',
            'cancelado'
        ];

        if (!in_array($dados['status'], $statusPermitidos)) {
            return [
                'success' => false,
                'message' => 'Status inválido'
            ];
        }

        return [
            'success' => $this->model->atualizarStatus(
                (int) $dados['id'],
                $dados['status']
            )
        ];
    }

    
}