<?php

require_once __DIR__ . '/../models/DentistaModel.php';

class DentistaController
{
    private DentistaModel $model;

    public function __construct()
    {
        $this->model = new DentistaModel();
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
    public function show(int $id): array|false
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

        // ✅ CAMPOS OBRIGATÓRIOS
        if (
            empty($dados['nome']) ||
            empty($dados['cpf']) ||
            empty($dados['sexo']) ||
            empty($dados['cro']) ||
            empty($dados['especialidade'])
        ) {
            return [
                'success' => false,
                'message' => 'Campos obrigatórios não preenchidos'
            ];
        }

        // ✅ VALIDAÇÃO DO SEXO (IGUAL AO PACIENTE)
        $sexosPermitidos = ['MASCULINO', 'FEMININO', 'OUTROS'];

        if (!in_array($dados['sexo'], $sexosPermitidos)) {
            return [
                'success' => false,
                'message' => 'Sexo inválido'
            ];
        }

        $ok = $this->model->criarDentistaCompleto($dados);

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

        // ✅ VALIDAÇÃO DO SEXO (SE VIER NO UPDATE)
        $sexosPermitidos = ['MASCULINO', 'FEMININO', 'OUTROS'];

        if (
            isset($dados['sexo']) &&
            !in_array($dados['sexo'], $sexosPermitidos)
        ) {
            return [
                'success' => false,
                'message' => 'Sexo inválido'
            ];
        }

        $ok = $this->model->atualizarDentistaCompleto($id, $dados);

        return [
            'success' => $ok
        ];
    }

    /* =========================
       DELETE (LÓGICO)
    ========================= */
    public function destroy(int $id): array
    {
        $ok = $this->model->excluirDentista($id);

        return [
            'success' => $ok
        ];
    }

    public function buscar(string $termo): array
{
    return $this->model->buscarPorNomeOuCro($termo);
}
}