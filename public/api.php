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
require_once __DIR__ . '/../app/controllers/ConsultaController.php';
require_once __DIR__ . '/../app/controllers/UsuarioController.php';
/* ======================
   INSTÂNCIAS
====================== */

$usuarioController = new UsuarioController();
$authController          = new AuthController();
$pacienteController      = new PacienteController();
$dentistaController      = new DentistaController();
$anamneseController      = new AnamneseController();
$procedimentoController  = new ProcedimentoController();
$orcamentoController     = new OrcamentoController();
$orcamentoItemController = new OrcamentoItemController();
$agendaController        = new AgendaController();
$consultaController      = new ConsultaController();


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
   LOGOUT
====================== */

if ($api === 'logout') {

    $_SESSION = [];
    session_destroy();

    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");

    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

/* ======================
   CADASTRO PÚBLICO
====================== */

if ($api === 'usuario-publico' && $method === 'POST') {
    $usuarioController->storePublico();
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
   PACIENTES
====================== */

if ($api === 'pacientes') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode($pacienteController->show((int)$_GET['id']));
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
        echo json_encode($pacienteController->update((int)$_GET['id']));
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode($pacienteController->destroy((int)$_GET['id']));
        exit;
    }
}

/* ======================
   DENTISTAS
====================== */

if ($api === 'dentistas') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode($dentistaController->show((int)$_GET['id']));
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
        echo json_encode($dentistaController->update((int)$_GET['id']));
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode($dentistaController->destroy((int)$_GET['id']));
        exit;
    }
}

/* ======================
   ANAMNESES
====================== */

if ($api === 'anamneses') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode($anamneseController->show((int)$_GET['id']));
        exit;
    }

    if ($method === 'GET' && isset($_GET['paciente_id'])) {
        echo json_encode(
            $anamneseController->porPaciente((int)$_GET['paciente_id'])
        );
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
        echo json_encode($anamneseController->update((int)$_GET['id']));
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode($anamneseController->destroy((int)$_GET['id']));
        exit;
    }
}

/* ======================
   PROCEDIMENTOS
====================== */

if ($api === 'procedimentos') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'GET') {
        echo json_encode($procedimentoController->index());
        exit;
    }

    if ($method === 'POST') {
        echo json_encode($procedimentoController->store());
        exit;
    }

    if ($method === 'PUT' && isset($_GET['id'])) {
        echo json_encode($procedimentoController->update((int)$_GET['id']));
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode($procedimentoController->destroy((int)$_GET['id']));
        exit;
    }
}

/* ======================
   AGENDA
====================== */

if ($api === 'agenda') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'GET') {
        echo json_encode($agendaController->index());
        exit;
    }

    if ($method === 'POST') {
        echo json_encode($agendaController->store());
        exit;
    }
}

if ($api === 'agenda-status' && $method === 'PUT') {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($agendaController->updateStatus());
    exit;
}

/* ======================
   CONSULTA
====================== */

if ($api === 'consulta-abrir' && $method === 'POST') {

    $agendaId = (int)($_POST['agenda_id'] ?? 0);

    if (!$agendaId) {
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }

    $consultaId = $consultaController->abrir($agendaId);

    if (!$consultaId) {
        echo json_encode(['success' => false]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'consulta_id' => $consultaId
    ]);
    exit;
}

if ($api === 'consulta' && $method === 'GET' && isset($_GET['agenda_id'])) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(
        $consultaController->buscarPorAgenda((int)$_GET['agenda_id'])
    );
    exit;
}

if ($api === 'consulta-finalizar' && $method === 'POST') {

    $agendaId = (int)($_POST['agenda_id'] ?? 0);
    $evolucao = $_POST['evolucao'] ?? '';

    if (!$agendaId) {
        http_response_code(400);
        echo json_encode(['success' => false]);
        exit;
    }

    $ok = $consultaController->finalizar($agendaId, $evolucao);

    if (!$ok) {
        echo json_encode(['success' => false]);
        exit;
    }

    header('Location: /teamOdonto/public/index.php?page=agenda');
    exit;
}

if ($api === 'consultas' && $method === 'GET') {

    header('Content-Type: application/json; charset=utf-8');

    /* ✅ BUSCAR POR ID */
    if (isset($_GET['id'])) {

        echo json_encode(
            $consultaController->buscarPorId((int)$_GET['id'])
        );
        exit;
    }

    /* ✅ LISTAR */
    echo json_encode(
        $consultaController->listarAjax()
    );
    exit;
}

/* ======================
   ORÇAMENTOS
====================== */

if ($api === 'orcamentos') {
    header('Content-Type: application/json; charset=utf-8');

    if ($method === 'GET' && isset($_GET['id'])) {
        echo json_encode($orcamentoController->show((int)$_GET['id']));
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
        echo json_encode($orcamentoController->updateStatus((int)$_GET['id']));
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'])) {
        echo json_encode($orcamentoController->destroy((int)$_GET['id']));
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
            $orcamentoItemController->index((int)$_GET['orcamento_id'])
        );
        exit;
    }

    if ($method === 'DELETE' && isset($_GET['id'], $_GET['orcamento_id'])) {
        echo json_encode(
            $orcamentoItemController->destroy(
                (int)$_GET['id'],
                (int)$_GET['orcamento_id']
            )
        );
        exit;
    }

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