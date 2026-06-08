<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

require_once __DIR__ . '/../../controllers/ConsultaController.php';

$consultaController = new ConsultaController();
$consultas = $consultaController->index();

$title = 'Consultas';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">

    <!-- TOPO -->
    <nav class="navbar navbar-custom sticky-top">
        <h5 class="mb-0 fw-bold">Consultas</h5>
    </nav>

    <div class="p-4 p-lg-5">

        <div class="card shadow-sm border-0">

            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Paciente</th>
                            <th>Dentista</th>
                            <th>Início</th>
                            <th>Status</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($consultas)): ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Nenhuma consulta registrada
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($consultas as $c): ?>
                                <tr>
                                    <td><?= htmlspecialchars($c['paciente_nome']) ?></td>
                                    <td><?= htmlspecialchars($c['dentista_nome']) ?></td>
                                    <td>
                                        <?= date('d/m/Y H:i', strtotime($c['data_inicio'])) ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $c['status'] === 'finalizada' ? 'success' : 'warning' ?>">
                                            <?= ucfirst($c['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="/teamOdonto/public/index.php?page=consulta-view&agenda_id=<?= $c['agenda_id'] ?>"
                                           class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>

        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>