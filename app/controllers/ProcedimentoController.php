<?php
require_once __DIR__ . '/../models/ProcedimentoModel.php';

class ProcedimentoController
{
    private ProcedimentoModel $model;

    public function __construct()
    {
        $this->model = new ProcedimentoModel();
    }

    public function index(): array
    {
        return $this->model->listar();
    }

    public function store(): array
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (
            !$dados ||
            empty($dados['nome']) ||
            empty($dados['valor'])
        ) {
            return [
                'success' => false,
                'message' => 'Nome e valor são obrigatórios.'
            ];
        }

        $ok = $this->model->criar($dados);

        return [
            'success' => $ok,
            'message' => $ok
                ? 'Procedimento cadastrado com sucesso.'
                : 'Erro ao cadastrar procedimento.'
        ];
    }

    public function show(int $id): array
    {
        return $this->model->buscarPorId($id) ?: [];
    }

    public function update(int $id): array
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (
            !$dados ||
            empty($dados['nome']) ||
            empty($dados['valor'])
        ) {
            return [
                'success' => false,
                'message' => 'Nome e valor são obrigatórios.'
            ];
        }

        $ok = $this->model->atualizar($id, $dados);

        return [
            'success' => $ok,
            'message' => $ok
                ? 'Procedimento atualizado com sucesso.'
                : 'Erro ao atualizar procedimento.'
        ];
    }

    public function destroy(int $id): array
    {
        $ok = $this->model->excluir($id);

        return [
            'success' => $ok,
            'message' => $ok
                ? 'Procedimento removido.'
                : 'Erro ao remover.'
        ];
    }
}