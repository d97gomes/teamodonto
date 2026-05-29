<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

// VIEW PURA 'Cadastro de Paciente';// VIEW PURA — CREATE
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<h3>Novo Procedimento</h3>

<form id="formProcedimento">
    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="nome" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Descrição</label>
        <textarea name="descricao" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Valor</label>
        <input type="number" name="valor" step="0.01" class="form-control" required>
    </div>

    <button class="btn btn-primary">Salvar</button>
</form>

<script src="/teamOdonto/public/js/procedimento/procedimento-create.js"></script>
