<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$orcamentoId = (int) ($_GET['id'] ?? 0);
$title = 'Detalhe do Orçamento';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <div class="container-fluid py-4">

        <!-- HEADER -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <h3 class="mb-0 fw-bold">Detalhe do Orçamento</h3>

        </div>

        <!-- ======================
             DADOS DO ORÇAMENTO
        ====================== -->
        <div class="card mb-4">
            <div class="card-header fw-bold">
                Dados do Orçamento
            </div>
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-12 col-md-6">
                        <p>
                            <strong>Paciente:</strong>
                            <span id="orcPaciente"></span>
                        </p>
                        <p>
                            <strong>Dentista:</strong>
                            <span id="orcDentista"></span>
                        </p>
                    </div>

                    <div class="col-12 col-md-6">
                        <p>
                            <strong>Data:</strong>
                            <span id="orcData"></span>
                        </p>
                        <p>
                            <strong>Status:</strong>
                            <span id="orcStatus"></span>
                        </p>
                    </div>

                </div>
            </div>
        </div>

        <!-- ======================
             ITENS DO ORÇAMENTO
        ====================== -->
        <div class="card mb-4">
            <div class="card-header fw-bold">
                Itens do Orçamento
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-sm align-middle mb-0">
                        <thead class="table-light">
                            <tr class="small fw-bold">
                                <th>Dente</th>
                                <th>Face</th>
                                <th>Procedimento</th>
                                <th>Valor (R$)</th>
                            </tr>
                        </thead>

                        <tbody id="tabelaItens">
                            <tr>
                                <td colspan="4"
                                    class="text-center text-muted py-4">
                                    Carregando...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- TOTAL -->
        <div class="card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <strong>Total</strong>
                <span class="fw-bold text-primary fs-5"
                      id="orcTotal">
                    R$ 0,00
                </span>
            </div>
        </div>

    <div class="d-flex justify-content-end gap-2 mt-4">

    <a href="/teamOdonto/public/index.php?page=orcamento-list"
       class="btn btn-secondary">
        Voltar
    </a>

   </div>

    </div>
</main>

<script>
    const ORCAMENTO_ID = <?= $orcamentoId ?>;
</script>

<script src="/teamOdonto/public/js/orcamento/orcamento-view.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>