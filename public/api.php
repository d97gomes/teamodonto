<?php
session_start();

/* ======================
   CONTROLLERS
====================== */

require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/PacienteController.php';
require_once __DIR__ . '/../app/controllers/DentistaController.php';
require_once __DIR__ . '/../app/controllers/AnamneseController.php';
require_once __DIR__ . '/../app/controllers/ProcedimentoController.php';
require_once __DIR__ . '/../app/controllers/OrcamentoController.php';
require_once __DIR__ . '/../app/controllers/OrcamentoItemController.php';
require_once __DIR__ . '/../app/controllers/AgendaController.php';

$authController          = new AuthController();
$pacienteController      = new PacienteController();
$dentistaController      = new DentistaController();
$anamneseController      = new AnamneseController();
$procedimentoController  = new ProcedimentoController();
$orcamentoController     = new OrcamentoController();
$orcamentoItemController = new OrcamentoItemController();
$agendaController        = new AgendaController();

$api    = $_GET['api'] ?? null;
$method = $_SERVER['REQUEST_METHOD'];

/* ======================
   LOGIN
====================== */

if ($api === 'login') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($authController->login());
    exit;
}

/* ======================
   LOGOUT (AJUSTADO)
====================== */

if ($api === 'logout') {

    // Limpa todas as variáveis de sessão
    $_SESSION = [];

    // Destrói a sessão
    session_destroy();

    // Evita cache após logout
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Pragma: no-cache");
    header("Expires: 0");

    // Redireciona para login
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

/* ======================
   PROTEÇÃO GLOBAL
====================== */

if (empty($_SESSION['usuario'])) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(401);
    echo json_encode([
        'success' => false,
        'message' => 'Não autorizado'
    ]);
    exit;
}

/* ======================
   DENTISTAS
====================== */

if ($api === 'dentistas') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode($dentistaController->show((int) $_GET['id']));
        exit;
    }

    if ($method === 'GET' && isset($_GET['search'])) {
        echo json_encode($dentistaController->buscar($_GET['search']));
        exit;
    }

    if ($method === 'GET') {
        echo json_encode($dentistaController->index());
        exit;
    }

    if ($method === 'POST') {
        echo json_encode($dentistaController->store());
        exit;
    }

    if ($method === 'PUT' && isset($_GET['id'])) {
        echo json_encode($dentistaController->update((int) $_GET['id']));
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode($dentistaController->destroy((int) $_GET['id']));
        exit;
    }
}

/* ======================
   PACIENTES
====================== */

if ($api === 'pacientes') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode($pacienteController->show((int) $_GET['id']));
        exit;
    }

    if ($method === 'GET' && isset($_GET['search'])) {
        echo json_encode($pacienteController->buscar($_GET['search']));
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
}

/* ======================
   ANAMNESES
====================== */

if ($api === 'anamneses') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode($anamneseController->show((int) $_GET['id']));
        exit;
    }

    if ($method === 'GET' && isset($_GET['paciente_id'])) {
        echo json_encode($anamneseController->porPaciente((int) $_GET['paciente_id']));
        exit;
    }

    if ($method === 'GET' && isset($_GET['dentista_id'])) {
        echo json_encode($anamneseController->porDentista((int) $_GET['dentista_id']));
        exit;
    }

    if ($method === 'GET') {
        echo json_encode($anamneseController->index());
        exit;
    }

    if ($method === 'POST') {
        echo json_encode($anamneseController->store());
        exit;
    }

    if ($method === 'PUT' && isset($_GET['id'])) {
        echo json_encode($anamneseController->update((int) $_GET['id']));
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode($anamneseController->destroy((int) $_GET['id']));
        exit;
    }
}

/* ======================
   PROCEDIMENTOS
====================== */

if ($api === 'procedimentos') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode($procedimentoController->show((int) $_GET['id']));
        exit;
    }

    if ($method === 'GET') {
        echo json_encode($procedimentoController->index());
        exit;
    }

    if ($method === 'POST') {
        echo json_encode($procedimentoController->store());
        exit;
    }

    if ($method === 'PUT' && isset($_GET['id'])) {
        echo json_encode($procedimentoController->update((int) $_GET['id']));
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode($procedimentoController->destroy((int) $_GET['id']));
        exit;
    }
}

/* ======================
   ORÇAMENTOS
====================== */

if ($api === 'orcamentos') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode($orcamentoController->show((int) $_GET['id']));
        exit;
    }

    if ($method === 'GET') {
        echo json_encode($orcamentoController->index());
        exit;
    }

    if ($method === 'POST') {
        echo json_encode($orcamentoController->store());
        exit;
    }

    if ($method === 'PUT' && isset($_GET['id'])) {
        echo json_encode($orcamentoController->updateStatus((int) $_GET['id']));
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode($orcamentoController->destroy((int) $_GET['id']));
        exit;
    }
}

/* ======================
   ORÇAMENTO ITENS
====================== */

if ($api === 'orcamento-itens') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'POST') {
        echo json_encode($orcamentoItemController->store());
        exit;
    }

    if ($method === 'GET' && isset($_GET['orcamento_id'])) {
        echo json_encode(
            $orcamentoItemController->index((int) $_GET['orcamento_id'])
        );
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'], $_GET['orcamento_id'])) {
        echo json_encode(
            $orcamentoItemController->destroy(
                (int) $_GET['id'],
                (int) $_GET['orcamento_id']
            )
        );
        exit;
    }
}

/* ======================
   AGENDA
====================== */

if ($api === 'agenda' && $method === 'GET') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($agendaController->index());
    exit;
}

if ($api === 'agenda' && $method === 'POST') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($agendaController->store());
    exit;
}

if ($api === 'agenda-status' && $method === 'PUT') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($agendaController->updateStatus());
    exit;
}

/* ======================
   FALLBACK
====================== */

header('Content-Type: application/json; charset=utf-8');
http_response_code(400);
echo json_encode([
    'success' => false,
    'message' => 'Requisição inválida'
]);
