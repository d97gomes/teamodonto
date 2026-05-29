<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';

$orcamentoId = $_GET['id'] ?? null;
?>

<h3>Detalhe do Orçamento</h3>

<div class="mb-3">
    <a href="index.php?page=orcamento-list" class="btn btn-light">
        Voltar
    </a>
</div>

<div class="card mb-4">
    <div class="card-header fw-bold">
        Dados do Orçamento
    </div>
    <div class="card-body">
        <p><strong>Paciente:</strong> <span id="orcPaciente"></span></p>
        <p><strong>Dentista:</strong> <span id="orcDentista"></span></p>
        <p><strong>Data:</strong> <span id="orcData"></span></p>
        <p><strong>Status:</strong> <span id="orcStatus"></span></p>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header fw-bold">
        Itens do Orçamento
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Dente</th>
                    <th>Face</th>
                    <th>Procedimento</th>
                    <th>Valor (R$)</th>
                </tr>
            </thead>
            <tbody id="tabelaItens"></tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-body d-flex justify-content-between">
        <strong>Total</strong>
        <span class="fw-bold text-primary fs-5" id="orcTotal"></span>
    </div>
</div>

<script>
    const ORCAMENTO_ID = <?= (int)$orcamentoId ?>;
</script>

<script src="/teamOdonto/public/js/orcamento/orcamento-view.js"></script>