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

<main class="main-content">
    <div class="container-fluid py-4">

        <!-- HEADER DA PÁGINA -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 fw-bold">Visualizar Anamnese</h3>

            <div class="d-flex gap-2">
                <a href="/teamOdonto/public/index.php?page=anamnese-edit&id=<?= (int)$id ?>"
                   class="btn btn-warning">
                    <i class="bi bi-pencil-square me-2"></i>
                    Editar
                </a>

                <a href="/teamOdonto/public/index.php?page=anamnese-list"
                   class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i>
                    Voltar
                </a>
            </div>
        </div>

        <!-- CARD PRINCIPAL -->
        <div class="card p-4">

            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-clipboard-heart fs-4 text-primary me-2"></i>
                <h5 class="fw-bold mb-0">Dados Clínicos</h5>
            </div>

            <div id="conteudoAnamnese">
                <p class="text-muted mb-0">
                    Carregando dados da anamnese...
                </p>
            </div>

        </div>

    </div>
</main>

<script src="/teamOdonto/public/js/anamnese/anamnese-view.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
