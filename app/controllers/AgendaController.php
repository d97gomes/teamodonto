<?php
require_once __DIR__ . '/../models/AgendaModel.php';

class AgendaController
{
    private AgendaModel $model;

    public function __construct()
    {
        $this->model = new AgendaModel();
    }

public function store(): array
{
    $dados = json_decode(file_get_contents('php://input'), true);

    if (
        empty($dados['paciente_id']) ||
        empty($dados['dentista_id']) ||
        empty($dados['data']) ||
        empty($dados['hora'])
        
    ) {
        return [
            'success' => false,
            'message' => 'Selecione paciente, dentista, data e hora.'
        ];
    }

    return [
        'success' => $this->model->criar($dados)
    ];
}

    public function index(): array
{
    $tipo = $_GET['tipo'] ?? 'dia';
    $data = $_GET['data'] ?? date('Y-m-d');

    return [
        'success' => true,
        'data' => $this->model->listar($tipo, $data)
    ];
}


    public function updateStatus(): array
{
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