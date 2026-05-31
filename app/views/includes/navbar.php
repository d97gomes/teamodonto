<nav class="navbar navbar-custom sticky-top">
    <div class="container-fluid">

        <!-- LOGO / NOME DO SISTEMA -->
        <span class="navbar-brand fw-bold text-primary">
            TeamOdonto
        </span>

        <!-- USUÁRIO + LOGOUT -->
        <div class="d-flex align-items-center gap-3">

            <?php if (!empty($_SESSION['usuario'])): ?>
                <span class="text-secondary fw-semibold">
                    <i class="bi bi-person-circle me-1"></i>
                    <?= htmlspecialchars($_SESSION['usuario']['nome']) ?>
                </span>
            <?php endif; ?>

            <a href="/teamOdonto/public/api.php?api=logout"
               class="btn btn-outline-danger btn-sm"
               aria-label="Sair do sistema">
                <i class="bi bi-box-arrow-right me-1"></i>
                Sair
            </a>

        </div>
    </div>
</nav>