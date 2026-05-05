<?php
require_once __DIR__ . '/../models/AnamneseModel.php';

class AnamneseController
{
    private AnamneseModel $model;

    public function __construct()
    {
        $this->model = new AnamneseModel();
    }

    /* ============================
       LISTAGEM GERAL (PAGINADA)
    ============================ */
    public function index(): array
    {
        $pagina = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;
        $limite = 10;
        $offset = ($pagina - 1) * $limite;

        return [
            'dados' => $this->model->listarPaginado($limite, $offset),
            'total' => $this->model->contarTotal(),
            'pagina' => $pagina,
            'limite' => $limite
        ];
    }

    /* ============================
       LISTAR POR PACIENTE
    ============================ */
    public function porPaciente(int $pacienteId): array
    {
        return $this->model->listarPorPaciente($pacienteId);
    }

    /* ============================
       LISTAR POR DENTISTA
    ============================ */
    public function porDentista(int $dentistaId): array
    {
        return $this->model->listarPorDentista($dentistaId);
    }

    /* ============================
       VISUALIZAR
    ============================ */
    public function show(int $id): array|false
    {
        return $this->model->buscarPorId($id);
    }

    /* ============================
       CRIAR
    ============================ */
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
                'message' => 'Paciente e dentista são obrigatórios'
            ];
        }

        $ok = $this->model->criar($dados);

        return [
            'success' => $ok
        ];
    }

    /* ============================
       ATUALIZAR
    ============================ */
    public function update(int $id): array
    {
        $dados = json_decode(file_get_contents('php://input'), true);

        if (!$dados) {
            return [
                'success' => false,
                'message' => 'Dados inválidos'
            ];
        }

        $ok = $this->model->atualizar($id, $dados);

        return [
            'success' => $ok
        ];
    }

    /* ============================
       EXCLUIR
    ============================ */
    public function destroy(int $id): array
    {
        $ok = $this->model->excluir($id);

        return [
            'success' => $ok
        ];
    }
}