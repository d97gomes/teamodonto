<?php
$title = 'Home';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';

?>

<div class="container-fluid">
    <div class="row">

        <?php require_once __DIR__ . '/../includes/sidebar.php'; ?>

        <main class="col-md-9 col-lg-10 px-4 mt-4">

            <h3>Dashboard</h3>

            <p>
                Bem-vindo,
                <strong><?= $_SESSION['usuario']['nome']; ?></strong>
            </p>

            <div class="alert alert-info">
                Selecione um módulo no menu lateral para começar.
            </div>

        </main>

    </div>
</div>

<?php
require_once __DIR__ . '/../includes/footer.php';
?>