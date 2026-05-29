<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<h3>Orçamentos</h3>

<div class="mb-3">
    <a href="index.php?page=orcamento-create" class="btn btn-primary">
        Novo Orçamento
    </a>
</div>

<div class="table-responsive">
    <table class="table table-bordered" id="tabelaOrcamentos">
        <thead class="table-light">
            <tr>
                <th>Paciente</th>
                <th>Dentista</th>
                <th>Data</th>
                <th>Total</th>
                <th>Status</th>
                <th width="180">Ações</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script src="/teamOdonto/public/js/orcamento/orcamento-list.js"></script>
