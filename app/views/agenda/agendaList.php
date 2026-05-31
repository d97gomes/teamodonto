<?php
if (!isset($_SESSION)) {
    session_start();
}

$title = 'Agenda';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <nav class="navbar navbar-custom sticky-top">
        <h5 class="mb-0 fw-bold">Agenda</h5>
    </nav>

    <div class="p-4 p-lg-5">
        <div class="card p-4 border-0 shadow-sm">

            <!-- CABEÇALHO + FILTROS + BOTÃO -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <h5 class="fw-bold mb-0 me-3">Agendamentos</h5>

                    <select id="tipoFiltro" class="form-select w-auto">
                        <option value="dia">Dia</option>
                        <option value="semana">Semana</option>
                        <option value="mes">Mês</option>
                    </select>

                    <input type="date" id="dataAgenda" class="form-control w-auto">
                </div>

                <!-- BOTÃO NOVO AGENDAMENTO -->
                <a href="index.php?page=agenda-create" class="btn btn-primary fw-bold">
                    + Novo Agendamento
                </a>

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

<!-- JS DA AGENDA -->
<script src="js/agenda/agenda-list.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
``