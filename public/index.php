<?php
session_start();
define('APP_ROUTER', true);

/* ======================
   PROTEÇÃO DE VIEWS
====================== */

$pagina = $_GET['page'] ?? 'home';
$paginasPublicas = ['login'];

if (!in_array($pagina, $paginasPublicas, true) && empty($_SESSION['usuario'])) {
    header('Location: index.php?page=login');
    exit;
}

/* ======================
   VIEWS
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

    case 'dentista-list':
        require __DIR__ . '/../app/views/dentista/dentistaList.php';
        break;

    case 'dentista-create':
        require __DIR__ . '/../app/views/dentista/dentistaCreate.php';
        break;

    case 'dentista-edit':
        require __DIR__ . '/../app/views/dentista/dentistaEdit.php';
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

    case 'procedimento-list':
        require __DIR__ . '/../app/views/procedimento/procedimentoList.php';
        break;

    case 'procedimento-create':
        require __DIR__ . '/../app/views/procedimento/procedimentoCreate.php';
        break;

    case 'procedimento-edit':
        require __DIR__ . '/../app/views/procedimento/procedimentoEdit.php';
        break;

    case 'orcamento-list':
        require __DIR__ . '/../app/views/orcamento/orcamentoList.php';
        break;

    case 'orcamento-create':
        require __DIR__ . '/../app/views/orcamento/orcamentoCreate.php';
        break;

    case 'orcamento-edit':
        require __DIR__ . '/../app/views/orcamento/orcamentoEdit.php';
        break;

    case 'orcamento-view':
        require __DIR__ . '/../app/views/orcamento/orcamentoView.php';
        break;

    case 'agenda':
    require '../app/views/agenda/agendaList.php';
    break;

        case 'agenda-create':
    require '../app/views/agenda/agendaCreate.php';
    break;


    default:
        echo 'Página não encontrada';
}