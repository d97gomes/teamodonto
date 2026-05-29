<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<h3>Procedimentos</h3>

<a href="index.php?page=procedimento-create" class="btn btn-primary mb-3">
    Novo Procedimento
</a>

<table class="table table-bordered" id="tabelaProcedimentos">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>

<!-- preenchido via JS -->
    </tbody>
</table>

<script src="/teamOdonto/public/js/procedimento/procedimento-list.js"></script>