<?php

require_once __DIR__ . '/../models/PacienteModel.php';

class PacienteController
{
    private PacienteModel $model;

    public function __construct()
    {
        $this->model = new PacienteModel();
    }

    /* =========================
       READ – LISTAR TODOS
    ========================= */
    public function index(): array
    {
        return $this->model->listarTodos();
    }

    /* =========================
       READ – BUSCAR POR ID
    ========================= */
    public function show(int $id): ?array
    {
        return $this->model->buscarPorId($id);
    }

    /* =========================
       CREATE
    ========================= */
    public function store(): array
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (!$dados) {
            return [
                'success' => false,
                'message' => 'Dados inválidos'
            ];
        }

        $ok = $this->model->criarPacienteCompleto($dados);

        return [
            'success' => $ok
        ];
    }

    /* =========================
       UPDATE
    ========================= */
    public function update(int $id): array
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (!$dados) {
            return [
                'success' => false,
                'message' => 'Dados inválidos'
            ];
        }

        $ok = $this->model->atualizarPacienteCompleto($id, $dados);

        return [
            'success' => $ok
        ];
    }

    /* =========================
       DELETE (LÓGICO)
    ========================= */
    public function destroy(int $id): array
    {
        $ok = $this->model->excluirPaciente($id);

        return [
            'success' => $ok
        ];
    }
}