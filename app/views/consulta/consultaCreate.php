<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

if (!isset($_GET['agenda_id'])) {
    header('Location: /teamOdonto/public/index.php?page=agenda');
    exit;
}

$agendaId = (int) $_GET['agenda_id'];

$title = 'Consulta Clínica';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
require_once __DIR__ . '/../../controllers/ConsultaController.php';

$consultaController = new ConsultaController();

/* ✅ ✅ CORREÇÃO PRINCIPAL (CRIA CONSULTA) */
$consultaId = $consultaController->abrir($agendaId);


$alertas = $consultaController->alertasAnamnese($agendaId);
?>

<main class="main-content">

    <nav class="navbar navbar-custom sticky-top">
        <h5 class="mb-0 fw-bold">Consulta Clínica</h5>
    </nav>

    <div class="p-4 p-lg-5">
        <div class="row g-4">

            <!-- COLUNA PRINCIPAL -->
            <div class="col-lg-8">

                <!-- CARD PACIENTE -->
                <div class="card p-4 border-0 shadow-sm mb-4 bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center"
                                 style="width:50px;height:50px;">
                                <i class="bi bi-person-fill fs-4"></i>
                            </div>

                            <div>
                                <h5 class="mb-0 fw-bold">Paciente em Atendimento</h5>
                                <small class="text-white-50">
                                    Consulta vinculada ao agendamento #<?= $agendaId ?>
                                </small>
                            </div>
                        </div>

                        <span class="badge bg-white text-primary fw-bold">
                            Em Atendimento
                        </span>
                    </div>
                </div>

                <!-- EVOLUÇÃO -->
                <div class="card p-4 border-0 shadow-sm">
                    <h6 class="fw-bold mb-4">Evolução da Consulta</h6>

                    <form method="post" action="/teamOdonto/public/api.php?api=consulta-finalizar">

                        <input type="hidden" name="agenda_id" value="<?= $agendaId ?>">

                        <div class="mb-4">
                            <label class="form-label small fw-bold">
                                Descrição do Atendimento
                            </label>

                            <textarea
                                name="evolucao"
                                class="form-control"
                                rows="8"
                                placeholder="Relato da consulta..."
                                required></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success fw-bold px-4">
                                Concluir Consulta
                            </button>
                        </div>

                    </form>
                </div>

            </div>

            <!-- COLUNA LATERAL -->
            <div class="col-lg-4">

                <div class="card p-4 border-0 shadow-sm mb-4">
                    <h6 class="fw-bold mb-3 text-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Alertas da Anamnese
                    </h6>

                    <?php if (empty($alertas)): ?>
                        <div class="alert alert-success py-2 mb-0">
                            <small class="fw-bold">
                                Nenhum alerta clínico registrado
                            </small>
                        </div>
                    <?php else: ?>
                        <?php foreach ($alertas as $alerta): ?>
                            <div class="alert alert-warning py-2 mb-2">
                                <small class="fw-bold">
                                    <?= htmlspecialchars($alerta) ?>
                                </small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="card p-4 border-0 shadow-sm">
                    <h6 class="fw-bold mb-3">Apoio à Consulta</h6>

                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item">✔ Consulta vinculada à agenda</li>
                        <li class="list-group-item">✔ Registro clínico em andamento</li>
                        <li class="list-group-item">✔ Orçamento poderá ser associado</li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>