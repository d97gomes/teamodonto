<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$title = 'Editar Procedimento';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <nav class="navbar navbar-custom sticky-top">
        <h5 class="mb-0 fw-bold">Editar Procedimento</h5>
    </nav>

    <div class="p-4 p-lg-5">
        <div class="card p-4 border-0 shadow-sm">

            <form id="formProcedimentoEdit">

                <input type="hidden"
                       id="procedimentoId"
                       value="<?= $_GET['id'] ?? '' ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nome</label>
                    <input type="text"
                           name="nome"
                           id="nome"
                           class="form-control"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Descrição</label>
                    <textarea name="descricao"
                              id="descricao"
                              class="form-control"
                              rows="3"></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Valor</label>
                    <input type="number"
                           name="valor"
                           id="valor"
                           step="0.01"
                           class="form-control"
                           required>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="/teamOdonto/public/index.php?page=procedimento-list"
                       class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="btn btn-primary fw-semibold">
                        Salvar Alterações
                    </button>
                </div>

            </form>

        </div>
    </div>
</main>

<script src="/teamOdonto/public/js/procedimento/procedimento-edit.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>