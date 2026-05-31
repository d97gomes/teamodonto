<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

if (!isset($_SESSION['usuario'])) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$title = 'Dashboard';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">

    <!-- NAVBAR INTERNA DA PÁGINA -->
    <nav class="navbar navbar-custom sticky-top mb-4">
        <h5 class="mb-0 fw-bold">Painel de Controle</h5>
    </nav>

    <div class="p-4 p-lg-5">

        <!-- BOAS-VINDAS -->
        <div class="mb-5">
            <h2 class="fw-bold text-dark">
                Olá, <?= $_SESSION['usuario']['nome']; ?> 👋
            </h2>
            <p class="text-secondary">
                Aqui está um resumo geral do sistema.
            </p>
        </div>

        <!-- CARDS DE RESUMO -->
        <div class="row g-4 mb-5">

            <div class="col-md-3">
                <div class="card stats-card h-100">
                    <div class="stats-icon bg-primary text-white">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <small class="text-uppercase fw-bold text-secondary">
                        Pacientes
                    </small>
                    <h3 class="fw-bold mb-0">--</h3>
                    <span class="text-muted small">Cadastrados</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stats-card h-100">
                    <div class="stats-icon bg-success text-white">
                        <i class="bi bi-person-badge-fill fs-4"></i>
                    </div>
                    <small class="text-uppercase fw-bold text-secondary">
                        Dentistas
                    </small>
                    <h3 class="fw-bold mb-0">--</h3>
                    <span class="text-muted small">Ativos</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stats-card h-100">
                    <div class="stats-icon bg-warning text-white">
                        <i class="bi bi-clipboard-heart fs-4"></i>
                    </div>
                    <small class="text-uppercase fw-bold text-secondary">
                        Anamneses
                    </small>
                    <h3 class="fw-bold mb-0">--</h3>
                    <span class="text-muted small">Registradas</span>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stats-card h-100">
                    <div class="stats-icon bg-danger text-white">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>
                    <small class="text-uppercase fw-bold text-secondary">
                        Orçamentos
                    </small>
                    <h3 class="fw-bold mb-0">--</h3>
                    <span class="text-muted small">Criados</span>
                </div>
            </div>

        </div>

        <!-- CARD INFORMATIVO -->
        <div class="card p-4">
            <h5 class="fw-bold mb-2">
                Acesso rápido
            </h5>
            <p class="text-secondary mb-0">
                Utilize o menu lateral para acessar pacientes, dentistas,
                anamneses, procedimentos e orçamentos.
            </p>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>