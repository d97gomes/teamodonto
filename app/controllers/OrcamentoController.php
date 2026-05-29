<?php
require_once __DIR__ . '/../models/OrcamentoModel.php';

class OrcamentoController
{
    private OrcamentoModel $model;

    public function __construct()
    {
        $this->model = new OrcamentoModel();
    }

    /**
     * LISTAR ORÇAMENTOS
     * (orcamento-list)
     */
    public function index(): array
    {
        return $this->model->listar();
    }

    /**
     * BUSCAR ORÇAMENTO POR ID
     * ✅ USADO NO EDIT E NO VIEW
     * ✅ RETORNA PACIENTE E DENTISTA (JOIN)
     */
    public function show(int $id): array
    {
        return $this->model->buscarParaFormulario($id) ?: [];
    }

    /**
     * CRIAR ORÇAMENTO
     */
    public function store(): array
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (
            !$dados ||
            empty($dados['paciente_id']) ||
            empty($dados['dentista_id'])
        ) {
            return [
                'success' => false,
                'message' => 'Paciente e dentista são obrigatórios.'
            ];
        }

        $orcamentoId = $this->model->criar(
            (int) $dados['paciente_id'],
            (int) $dados['dentista_id']
        );

        if (!$orcamentoId) {
            return [
                'success' => false,
                'message' => 'Erro ao criar orçamento.'
            ];
        }

        return [
            'success' => true,
            'orcamento_id' => $orcamentoId
        ];
    }

    /**
     * ATUALIZAR STATUS
     */
    public function updateStatus(int $id): array
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (empty($dados['status'])) {
            return [
                'success' => false,
                'message' => 'Status inválido.'
            ];
        }

        $ok = $this->model->atualizarStatus($id, $dados['status']);

        return [
            'success' => $ok,
            'message' => $ok
                ? 'Status atualizado.'
                : 'Erro ao atualizar status.'
        ];
    }

    /**
     * EXCLUIR ORÇAMENTO
     */
    public function destroy(int $id): array
    {
        $ok = $this->model->excluir($id);

        return [
            'success' => $ok,
            'message' => $ok
                ? 'Orçamento removido.'
                : 'Erro ao remover orçamento.'
        ];
    }
}
