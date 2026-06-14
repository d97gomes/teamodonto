<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$orcamentoId = (int) ($_GET['id'] ?? 0);
$title = 'Editar Orçamento';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <div class="container-fluid py-4">

        <!-- HEADER -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
            <h3 class="mb-0 fw-bold">Editar Orçamento</h3>
        </div>

        <input type="hidden" id="orcamentoId" value="<?= $orcamentoId ?>">

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
                        <label class="form-label fw-semibold">Paciente</label>
                        <input type="text"
                               id="pacienteNome"
                               class="form-control"
                               readonly>
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label fw-semibold">Dentista</label>
                        <input type="text"
                               id="dentistaNome"
                               class="form-control"
                               readonly>
                    </div>

                    <div class="col-12 col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select id="statusSelect" class="form-select">
                            <option value="aberto">Aberto</option>
                            <option value="aprovado">Aprovado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
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

                <!-- FORM ITEM -->
                <div class="row g-3 align-items-end mb-3">

                    <div class="col-12 col-md-4">
                        <label class="form-label fw-semibold">Procedimento</label>
                        <select id="procedimentoSelect" class="form-select">
                            <option value="">Selecione</option>
                        </select>
                    </div>

                    <div class="col-6 col-md-2">
                        <label class="form-label fw-semibold">Dente</label>
                        <select id="denteSelect" class="form-select">
                            <option value="">Selecione</option>
                            <!-- opções FDI mantidas -->
                        </select>
                    </div>

                    <div class="col-6 col-md-2">
                        <label class="form-label fw-semibold">Face</label>
                        <select id="faceSelect" class="form-select">
                            <option value="">--</option>
                            <option value="O">O</option>
                            <option value="M">M</option>
                            <option value="D">D</option>
                            <option value="V">V</option>
                            <option value="L">L</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-2">
                        <button id="btnAdicionarItem"
                                class="btn btn-success w-100">
                            Adicionar
                        </button>
                    </div>

                </div>

                <!-- TABELA DE ITENS -->
                <div class="table-responsive">
                    <table class="table table-sm align-middle">
                        <thead class="table-light">
                            <tr class="small fw-bold">
                                <th>Dente</th>
                                <th>Face</th>
                                <th>Procedimento</th>
                                <th>Valor</th>
                                <th class="text-center">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="tabelaItens">
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Carregando...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- TOTAL -->
        <div class="card mb-4">
            <div class="card-body d-flex justify-content-between align-items-center">
                <strong>Total</strong>
                <span id="totalOrcamento"
                      class="fw-bold text-primary fs-5">
                    R$ 0,00
                </span>
            </div>
        </div>

    <div class="d-flex justify-content-end gap-2 mt-4">

    <a href="/teamOdonto/public/index.php?page=orcamento-list"
       class="btn btn-secondary">
        Voltar
    </a>

    <button id="btnSalvarOrcamento"
            class="btn btn-primary fw-bold">
        Salvar
    </button>

   </div>

    </div>
</main>

<script src="/teamOdonto/public/js/orcamento/orcamento-edit.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>