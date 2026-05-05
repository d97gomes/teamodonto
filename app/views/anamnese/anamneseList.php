<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$title = 'Anamneses';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Anamneses</h3>

        <a href="/teamOdonto/public/index.php?page=anamnese-create"
           class="btn btn-primary">
            Nova Anamnese
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Data</th>
                    <th>Paciente</th>
                    <th>Dentista</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>

            <tbody id="listaAnamneses">
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        Carregando...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- PAGINAÇÃO -->
    <nav>
        <ul class="pagination justify-content-center mt-3"
            id="paginacaoAnamneses">
        </ul>
    </nav>

</div>

<script src="/teamOdonto/public/js/anamnese/anamnese-list.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>