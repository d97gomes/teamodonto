<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /teamOdonto/public/index.php?page=anamnese-list');
    exit;
}

$title = 'Visualizar Anamnese';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Visualizar Anamnese</h3>

        <div>
            <a href="/teamOdonto/public/index.php?page=anamnese-edit&id=<?= (int)$id ?>"
               class="btn btn-warning">
                Editar
            </a>

            <a href="/teamOdonto/public/index.php?page=anamnese-list"
               class="btn btn-outline-secondary">
                Voltar
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header fw-bold">Dados Clínicos</div>

        <div class="card-body" id="conteudoAnamnese">
            <p class="text-muted">Carregando dados da anamnese...</p>
        </div>
    </div>

</div>

<script src="/teamOdonto/public/js/anamnese/anamnese-view.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>