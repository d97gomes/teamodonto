<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<h3>Editar Procedimento</h3>

<form id="formProcedimentoEdit">
    <input type="hidden" id="procedimentoId"
           value="<?= $_GET['id'] ?? '' ?>">

    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="nome" id="nome"
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Descrição</label>
        <textarea name="descricao" id="descricao"
                  class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label>Valor</label>
        <input type="number" name="valor" id="valor"
               step="0.01" class="form-control" required>
    </div>

    <button class="btn btn-primary">Salvar</button>
</form>

<script src="/teamOdonto/public/js/procedimento/procedimento-edit.js"></script>
