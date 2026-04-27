<?php
session_start();

require_once __DIR__ . '/../app/controllers/PacienteController.php';
$pacienteController = new PacienteController();

/* ======================
   API (JSON)
====================== */

if (isset($_GET['api']) && $_GET['api'] === 'pacientes') {

    header('Content-Type: application/json; charset=utf-8');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode($pacienteController->show((int)$_GET['id']));
        exit;
    }

    if ($method === 'GET') {
        echo json_encode($pacienteController->index());
        exit;
    }

    if ($method === 'POST') {
        echo json_encode($pacienteController->store());
        exit;
    }

    if ($method === 'PUT' && isset($_GET['id'])) {
        echo json_encode($pacienteController->update((int)$_GET['id']));
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode($pacienteController->destroy((int)$_GET['id']));
        exit;
    }

    http_response_code(400);
    echo json_encode(['error' => 'Requisição inválida']);
    exit;
}

/* ======================
   VIEWS (HTML)
====================== */

if (isset($_GET['page'])) {

    header('Content-Type: text/html; charset=utf-8');

    switch ($_GET['page']) {
        case 'paciente-list':
            require __DIR__ . '/../app/views/paciente/pacienteList.php';
            break;

        case 'paciente-create':
            require __DIR__ . '/../app/views/paciente/pacienteCreate.php';
            break;

        case 'paciente-edit':
            require __DIR__ . '/../app/views/paciente/pacienteEdit.php';
            break;

        case 'paciente-view':
            require __DIR__ . '/../app/views/paciente/pacienteView.php';
            break;

        default:
            echo 'Página não encontrada';
    }

    exit;
}

echo 'Sistema ativo';