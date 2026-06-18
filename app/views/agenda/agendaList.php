<?php
if (!isset($_SESSION)) {
    session_start();
}

$title = 'Agenda';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">

    <!-- HEADER PADRÃO -->
    <div class="container-fluid px-3 px-md-4 px-lg-5 pt-4">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h4 class="fw-bold mb-0">Agenda</h4>

            <a href="index.php?page=agenda-create" class="btn btn-primary fw-bold">
                + Novo Agendamento
            </a>

        </div>

        <!-- CARD -->
        <div class="card p-3 p-md-4 border-0 shadow-sm">

            <!-- FILTROS -->
            <div class="d-flex flex-wrap align-items-center gap-2 mb-4">

                <h6 class="fw-bold mb-0 me-2">Agendamentos</h6>

                <select id="tipoFiltro" class="form-select w-auto">
                    <option value="dia">Dia</option>
                    <option value="semana">Semana</option>
                    <option value="mes" selected>Mês</option>
                </select>

                <input type="date"
                       id="dataAgenda"
                       class="form-control w-auto">

            </div>

            <!-- LISTA -->
            <div class="list-group list-group-flush" id="listaAgenda">

                <div class="text-muted text-center py-3">
                    Carregando agenda...
                </div>

            </div>

        </div>

    </div>

</main>

<!-- ✅ JS -->
<script src="/teamOdonto/public/js/agenda/agenda-list.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>