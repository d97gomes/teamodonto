<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$agendaId = $_GET['agenda_id'] ?? null;
if (!$agendaId) {
    header('Location: /teamOdonto/public/index.php?page=agenda');
    exit;
}

$title = 'Consulta Clínica';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <div class="container-fluid py-4">

        <!-- CABEÇALHO -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">Consulta Clínica</h3>

            <a href="/teamOdonto/public/index.php?page=agenda"
               class="btn btn-outline-secondary">
                Voltar para Agenda
            </a>
        </div>

        <!-- CARD PACIENTE -->
        <div class="card p-4 mb-4 bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="fw-bold mb-1" id="pacienteNome">Carregando...</h5>
                    <small id="dentistaNome">Dentista</small>
                </div>

                <span class="badge bg-light text-primary fw-bold">
                    Em Atendimento
                </span>
            </div>
        </div>

        <!-- EVOLUÇÃO -->
        <div class="card p-4">
            <h6 class="fw-bold mb-3">Evolução da Consulta</h6>

            <textarea id="evolucao"
                      class="form-control mb-4"
                      rows="8"
                      placeholder="Descreva a evolução do atendimento..."></textarea>

            <div class="d-flex justify-content-end gap-2">
                <button class="btn btn-success px-4"
                        onclick="finalizarConsulta()">
                    Concluir Consulta
                </button>
            </div>
        </div>

    </div>
</main>

<script>
    const AGENDA_ID = <?= (int) $agendaId ?>;
</script>

<script src="/teamOdonto/public/js/consulta/consulta-view.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>