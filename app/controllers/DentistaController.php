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
       CREATE ✅ COMPLETO
    ========================= */
    public function store(): array
    {
        // ✅ aceita JSON (axios)
        $dados = json_decode(file_get_contents('php://input'), true);

        // ✅ fallback para formulário
        if (!$dados) {
            $dados = $_POST;
        }

        if (!$dados) {
            return [
                'success' => false,
                'message' => 'Nenhum dado recebido'
            ];
        }

        // ✅ validação básica
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

        $sexosPermitidos = ['MASCULINO', 'FEMININO', 'OUTROS'];

        if (!in_array($dados['sexo'], $sexosPermitidos)) {
            return [
                'success' => false,
                'message' => 'Sexo inválido'
            ];
        }

        $ok = $this->model->criarDentistaCompleto($dados);

        return [
            'success' => $ok,
            'message' => $ok ? 'Dentista criado ✅' : 'Erro ao criar ❌'
        ];
    }

    /* =========================
       UPDATE ✅ COMPLETO
    ========================= */
    public function update(int $id): array
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (!$dados) {
            $dados = $_POST;
        }

        if (!$dados) {
            return [
                'success' => false,
                'message' => 'Dados inválidos'
            ];
        }

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
            'success' => $ok,
            'message' => $ok ? 'Atualizado ✅' : 'Erro ao atualizar ❌'
        ];
    }

    /* =========================
       DELETE
    ========================= */
    public function destroy(int $id): array
    {
        $ok = $this->model->excluirDentista($id);

        return [
            'success' => $ok,
            'message' => $ok ? 'Excluído ✅' : 'Erro ao excluir ❌'
        ];
    }

    /* =========================
       BUSCA AJAX
    ========================= */
    public function buscar(string $termo): array
    {
        return $this->model->buscarPorNomeOuCro($termo);
    }
}