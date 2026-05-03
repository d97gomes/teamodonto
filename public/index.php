<?php
session_start();
define('APP_ROUTER', true);

/* ======================
   CONTROLLERS
====================== */

require_once __DIR__ . '/../app/controllers/PacienteController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';

$pacienteController = new PacienteController();
$authController = new AuthController();

/* ======================
   API AUTH (LOGIN) - PÚBLICA
====================== */

if (isset($_GET['api']) && $_GET['api'] === 'login') {

    header('Content-Type: application/json; charset=utf-8');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo json_encode($authController->login());
        exit;
    }

    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Método não permitido'
    ]);
    exit;
}

/* ======================
   API AUTH (LOGOUT) - PRIVADA
====================== */

if (isset($_GET['api']) && $_GET['api'] === 'logout') {

    if (empty($_SESSION['usuario'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Não autorizado']);
        exit;
    }

    session_destroy();
    header('Location: index.php?page=login');
    exit;
}

/* ======================
   API PACIENTES - PRIVADA
====================== */

if (isset($_GET['api']) && $_GET['api'] === 'pacientes') {

    if (empty($_SESSION['usuario'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Não autorizado']);
        exit;
    }

    header('Content-Type: application/json; charset=utf-8');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode($pacienteController->show((int) $_GET['id']));
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
        echo json_encode($pacienteController->update((int) $_GET['id']));
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode($pacienteController->destroy((int) $_GET['id']));
        exit;
    }

    http_response_code(400);
    echo json_encode(['error' => 'Requisição inválida']);
    exit;
}

/* ======================
   PROTEÇÃO DE VIEWS
====================== */

$pagina = $_GET['page'] ?? 'home';

/* páginas públicas */
$paginasPublicas = ['login'];

/* proteção centralizada */
if (!in_array($pagina, $paginasPublicas, true) && empty($_SESSION['usuario'])) {
    header('Location: index.php?page=login');
    exit;
}

/* ======================
   VIEWS (HTML)
====================== */

header('Content-Type: text/html; charset=utf-8');

switch ($pagina) {

    case 'login':
        require __DIR__ . '/../app/views/auth/login.php';
        break;

    case 'home':
        require __DIR__ . '/../app/views/home/home.php';
        break;

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