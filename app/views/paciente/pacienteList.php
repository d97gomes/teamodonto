<?php
$title = 'Pacientes';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Pacientes</h3>

        <a href="/teamOdonto/public/index.php?page=paciente-create"
           class="btn btn-primary">
            + Novo Paciente
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="listaPacientes">
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        Carregando...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script src="/teamOdonto/public/js/paciente/paciente-list.js"></script>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
