<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$title = 'Home';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<?php
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php?page=login');
    exit;
}
?>

<div class="container-fluid">
    <div class="row">

        <main class="col-md-9 col-lg-10 px-4 mt-4">

            <h3>Dashboard</h3>

            <p>
                Bem-vindo,
                <strong><?= $_SESSION['usuario']['nome'] ?></strong>
            </p>

            <div class="alert alert-info">
                Selecione um módulo no menu lateral para começar.
            </div>

        </main>

    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>