<?php
// Mock opcional
if (!isset($nivel)) {
    $nivel = $_GET['role'] ?? 'adm';
}
?>

<div class="d-flex">

    <!-- ✅ SIDEBAR ORIGINAL (COR AZUL MANTIDA) -->
    <div class="sidebar d-none d-lg-block sticky-top d-flex flex-column"
         style="width: 280px; height: 100vh;">

        <!-- LOGO -->
        <div class="p-4 mb-3 d-flex align-items-center gap-3">
            <div class="bg-primary rounded-3 flex-shrink-0 d-flex align-items-center justify-content-center"
                 style="width: 40px; height: 40px;">
                <span class="fw-bold text-white">T</span>
            </div>
            <h4 class="mb-0 fw-bold text-white">TeamOdonto</h4>
        </div>

        <!-- MENU -->
        <nav class="nav flex-column px-3">

            <a href="/teamOdonto/public/index.php?page=home" class="nav-link">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="/teamOdonto/public/index.php?page=paciente-list" class="nav-link">
                <i class="bi bi-people"></i> Pacientes
            </a>

            <a href="/teamOdonto/public/index.php?page=dentista-list" class="nav-link">
                <i class="bi bi-person-badge"></i> Dentistas
            </a>

            <a href="/teamOdonto/public/index.php?page=anamnese-list" class="nav-link">
                <i class="bi bi-clipboard-heart"></i> Anamneses
            </a>

            <a href="/teamOdonto/public/index.php?page=procedimento-list" class="nav-link">
                <i class="bi bi-tools"></i> Procedimentos
            </a>

            <a href="/teamOdonto/public/index.php?page=orcamento-list" class="nav-link">
                <i class="bi bi-file-earmark-text"></i> Orçamentos
            </a>

            <a href="/teamOdonto/public/index.php?page=agenda" class="nav-link">
                <i class="bi bi-calendar-event"></i> Agenda
            </a>

        </nav>

        <!-- ✅ USUÁRIO (SEM ALTERAR COR 🔵) -->
        <div class="mt-auto px-3 pb-4">

            <!-- Usando transparência leve (não quebra o azul) -->
            <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08);">

                <?php if (!empty($_SESSION['usuario'])): ?>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-person-circle text-white"></i>
                        <small class="text-white fw-bold">
                            <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>
                        </small>
                    </div>
                <?php endif; ?>

                <a href="/teamOdonto/public/api.php?api=logout"
                   class="text-danger text-decoration-none fw-bold small">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    Sair do sistema
                </a>

            </div>

        </div>

    </div>

    <!-- ✅ CONTEÚDO -->
    <main class="main-content flex-grow-1">