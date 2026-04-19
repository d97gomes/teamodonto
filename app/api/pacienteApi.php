<?php
header('Content-Type: application/json; charset=utf-8');

require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/controllers/pacienteController.php';

$db = Database::conectar();
$controller = new PacienteController($db);

$action = $_GET['action'] ?? '';

try {

    switch ($action) {

        // ✅ LISTAR
        case 'list':
            echo json_encode($controller->listarPacientes());
            break;

        // ✅ CRIAR
        case 'create':
            $dados = json_decode(file_get_contents("php://input"), true);
            echo json_encode([
                'success' => $controller->criarPacienteComEndereco($dados)
            ]);
            break;

        // ✅ ATUALIZAR
        case 'update':
            $dados = json_decode(file_get_contents("php://input"), true);
            echo json_encode([
                'success' => $controller->atualizarPacienteComEndereco($dados)
            ]);
            break;

        // ✅ EXCLUIR
        case 'delete':
            $id = $_GET['id'] ?? 0;
            echo json_encode([
                'success' => $controller->excluirPaciente((int)$id)
            ]);
            break;

        default:
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Ação inválida'
            ]);
    }

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Erro interno no servidor',
        'error'   => $e->getMessage()
    ]);
}
