<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$id = $_GET['id'] ?? null;

/* ✅ NÃO REDIRECIONAR SILENCIOSO */
if (!$id) {
    echo "<div class='alert alert-danger m-3'>
            Consulta não informada ❌
          </div>";
    exit;
}

$title = 'Consulta';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<!-- ✅ IMPORTANTE: data-id para o JS -->
<main class="main-content" data-id="<?= (int)$id ?>">

<div class="container-fluid px-3 px-md-4 pt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between mb-4">
        <h4 class="fw-bold mb-0">Detalhes da Consulta</h4>

        <a href="/teamOdonto/public/index.php?page=agenda"
           class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <!-- CARD -->
    <div class="card p-4 shadow-sm">

        <div class="row g-3">

            <div class="col-md-6">
                <strong>Paciente:</strong>
                <div id="consultaPaciente">--</div>
            </div>

            <div class="col-md-6">
                <strong>Dentista:</strong>
                <div id="consultaDentista">--</div>
            </div>

            <div class="col-md-6">
                <strong>Data:</strong>
                <div id="consultaData">--</div>
            </div>

            <div class="col-md-6">
                <strong>Status:</strong>
                <div id="consultaStatus">--</div>
            </div>

        </div>

        <hr>

        <div>
            <strong>Evolução:</strong>

            <div class="border p-3 rounded bg-light mt-2"
                 id="consultaEvolucao">
            </div>
        </div>

    </div>

</div>

</main>

<!-- ✅ JS correto -->
<script src="/teamOdonto/public/js/consulta/consulta-view.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>