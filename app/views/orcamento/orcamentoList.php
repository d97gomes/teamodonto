<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$title = 'Orçamentos';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <div class="container-fluid py-4">

        <!-- HEADER DA PÁGINA -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <h3 class="mb-0 fw-bold">Orçamentos</h3>

            <a href="/teamOdonto/public/index.php?page=orcamento-create"
               class="btn btn-primary">
                <i class="bi bi-plus-lg me-2"></i>
                Novo Orçamento
            </a>
        </div>

        <!-- BUSCA -->
        <div class="row mb-3">
            <div class="col-12 col-md-4">
                <input
                    type="text"
                    id="buscaNome"
                    class="form-control form-control-sm"
                    placeholder="Buscar por nome">
            </div>
        </div>

        <!-- CARD COM A TABELA -->
        <div class="card p-4">

            <div class="table-responsive">
                <table class="table table-sm align-middle mb-0"
                       id="tabelaOrcamentos">
                    <thead class="table-light">
                        <tr class="small fw-bold">
                            <th>Paciente</th>
                            <th>Dentista</th>
                            <th>Data</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="6"
                                class="text-center text-muted py-4">
                                Carregando...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- PAGINAÇÃO -->
            <nav class="mt-4">
                <ul
                    class="pagination justify-content-center mb-0"
                    id="paginacaoOrcamentos">
                </ul>
            </nav>

        </div>
    </div>
</main>

<script src="/teamOdonto/public/js/orcamento/orcamento-list.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>