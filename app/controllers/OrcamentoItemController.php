<?php
require_once __DIR__ . '/../models/OrcamentoItemModel.php';
require_once __DIR__ . '/../models/OrcamentoModel.php';

class OrcamentoItemController
{
    private OrcamentoItemModel $itemModel;
    private OrcamentoModel $orcamentoModel;

    public function __construct()
    {
        $this->itemModel = new OrcamentoItemModel();
        $this->orcamentoModel = new OrcamentoModel();
    }

    /**
     * Adiciona item ao orçamento
     */
    public function store(): array
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (
            !$dados ||
            empty($dados['orcamento_id']) ||
            empty($dados['procedimento_id']) ||
            empty($dados['dente']) ||
            empty($dados['face'])
        ) {
            return [
                'success' => false,
                'message' => 'Dados incompletos.'
            ];
        }

        $ok = $this->itemModel->adicionar(
            (int) $dados['orcamento_id'],
            (int) $dados['procedimento_id'],
            (int) $dados['dente'],
            strtoupper($dados['face'])
        );

        if (!$ok) {
            return [
                'success' => false,
                'message' => 'Erro ao adicionar item.'
            ];
        }

        // ✅ Atualiza total do orçamento
        $this->orcamentoModel->atualizarTotal(
            (int) $dados['orcamento_id']
        );

        return [
            'success' => true
        ];
    }

    /**
     * Lista itens de um orçamento
     */
    public function index(int $orcamentoId): array
    {
        return $this->itemModel->listarPorOrcamento($orcamentoId);
    }

    /**
     * Remove item do orçamento
     */
    public function destroy(int $itemId, int $orcamentoId): array
    {
        $ok = $this->itemModel->remover($itemId);

        if ($ok) {
            $this->orcamentoModel->atualizarTotal($orcamentoId);
        }

        return [
            'success' => $ok
        ];
    }
}
