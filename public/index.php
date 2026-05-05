<?php
session_start();
define('APP_ROUTER', true);

/* ======================
   CONTROLLERS
====================== */

require_once __DIR__ . '/../app/controllers/PacienteController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/DentistaController.php';

$dentistaController = new DentistaController();
$pacienteController = new PacienteController();
$authController = new AuthController();

/* ======================
   API DENTISTAS
====================== */

if (isset($_GET['api']) && $_GET['api'] === 'dentistas') {

    // ✅ proteção da API
    if (empty($_SESSION['usuario'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Não autorizado']);
        exit;
    }

    header('Content-Type: application/json; charset=utf-8');
    $method = $_SERVER['REQUEST_METHOD'];

    // ✅ READ – BUSCAR POR ID (PRIMEIRO)
    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode(
            $dentistaController->show((int) $_GET['id'])
        );
        exit;
    }

        // BUSCA DE DENTISTA
    if ($method === 'GET' && isset($_GET['search'])) {
        echo json_encode(
            $dentistaController->buscar($_GET['search'])
        );
        exit;
    }

    // ✅ READ – LISTAR TODOS (DEPOIS)
    if ($method === 'GET') {
        echo json_encode(
            $dentistaController->index()
        );
        exit;
    }

    // CREATE
    if ($method === 'POST') {
        echo json_encode(
            $dentistaController->store()
        );
        exit;
    }

    // UPDATE
    if ($method === 'PUT' && isset($_GET['id'])) {
        echo json_encode(
            $dentistaController->update((int) $_GET['id'])
        );
        exit;
    }

    // DELETE (LÓGICO)
    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode(
            $dentistaController->destroy((int) $_GET['id'])
        );
        exit;
    }

    http_response_code(400);
    echo json_encode(['error' => 'Requisição inválida']);
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

            // BUSCA DE PACIENTE
    if ($method === 'GET' && isset($_GET['search'])) {
        echo json_encode(
            $pacienteController->buscar($_GET['search'])
        );
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
   API ANAMNESES
====================== */

if (isset($_GET['api']) && $_GET['api'] === 'anamneses') {

    if (empty($_SESSION['usuario'])) {
        http_response_code(401);
        echo json_encode(['error' => 'Não autorizado']);
        exit;
    }

    header('Content-Type: application/json; charset=utf-8');
    $method = $_SERVER['REQUEST_METHOD'];

    require_once __DIR__ . '/../app/controllers/AnamneseController.php';
    $anamneseController = new AnamneseController();

    

    /* ======================
       READ – POR ID
    ====================== */
    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode(
            $anamneseController->show((int) $_GET['id'])
        );
        exit;
    }

    /* ======================
       READ – POR PACIENTE
    ====================== */
    if ($method === 'GET' && isset($_GET['paciente_id'])) {
        echo json_encode(
            $anamneseController->porPaciente((int) $_GET['paciente_id'])
        );
        exit;
    }

    /* ======================
       READ – POR DENTISTA
    ====================== */
    if ($method === 'GET' && isset($_GET['dentista_id'])) {
        echo json_encode(
            $anamneseController->porDentista((int) $_GET['dentista_id'])
        );
        exit;
    }

    /* ======================
       READ – LISTAGEM GERAL (PAGINADA)
    ====================== */
    if ($method === 'GET') {
        echo json_encode(
            $anamneseController->index()
        );
        exit;
    }

    /* ======================
       CREATE
    ====================== */
    if ($method === 'POST') {
        echo json_encode(
            $anamneseController->store()
        );
        exit;
    }

    /* ======================
       UPDATE
    ====================== */
    if ($method === 'PUT' && isset($_GET['id'])) {
        echo json_encode(
            $anamneseController->update((int) $_GET['id'])
        );
        exit;
    }

    /* ======================
       DELETE
    ====================== */
    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode(
            $anamneseController->destroy((int) $_GET['id'])
        );
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

    case 'dentista-create':
        require __DIR__ . '/../app/views/dentista/dentistaCreate.php';
        break;

    case 'dentista-edit':
        require __DIR__ . '/../app/views/dentista/dentistaEdit.php';
        break;

    case 'dentista-list':
        require __DIR__ . '/../app/views/dentista/dentistaList.php';
    break;

    case 'dentista-view':
        require __DIR__ . '/../app/views/dentista/dentistaView.php';
    break;

    case 'anamnese-list':
        require __DIR__ . '/../app/views/anamnese/anamneseList.php';
        break;

    case 'anamnese-create':
        require __DIR__ . '/../app/views/anamnese/anamneseCreate.php';
        break;

    case 'anamnese-edit':
        require __DIR__ . '/../app/views/anamnese/anamneseEdit.php';
        break;

    case 'anamnese-view':
        require __DIR__ . '/../app/views/anamnese/anamneseView.php';
        break;    

    default:
        echo 'Página não encontrada';
}