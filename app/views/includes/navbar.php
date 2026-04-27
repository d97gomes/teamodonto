<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">TeamOdonto</span>

        <div class="d-flex align-items-center">
            <span class="text-white me-3">
                <?= $_SESSION['usuario']['nome'] ?? 'Administrador'; ?>
            </span>
            <a href="/auth/logout" class="btn btn-light btn-sm">Sair</a>
        </div>
    </div>
</nav>