<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: /teamOdonto/public/index.php?page=anamnese-list');
    exit;
}

$title = 'Editar Anamnese';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <div class="container-fluid py-4">

        <!-- HEADER DA PÁGINA -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 fw-bold">Editar Anamnese</h3>

            <a href="/teamOdonto/public/index.php?page=anamnese-list"
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar
            </a>
        </div>

        <!-- CARD PRINCIPAL -->
        <div class="card p-4">

            <form id="formAnamneseEdit" data-id="<?= (int)$id ?>">

                <!-- =====================
                     HISTÓRICO MÉDICO
                ====================== -->
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-heart-pulse fs-5 text-primary me-2"></i>
                    <h6 class="fw-bold mb-0">Histórico Médico</h6>
                </div>

                <div class="row">
                    <div class="col-md-3 form-check">
                        <input class="form-check-input" type="checkbox" id="diabetes">
                        <label class="form-check-label">Diabetes</label>
                    </div>

                    <div class="col-md-3 form-check">
                        <input class="form-check-input" type="checkbox" id="hipertensao">
                        <label class="form-check-label">Hipertensão</label>
                    </div>

                    <div class="col-md-3 form-check">
                        <input class="form-check-input" type="checkbox" id="problemas_cardiacos">
                        <label class="form-check-label">Problemas Cardíacos</label>
                    </div>

                    <div class="col-md-3 form-check">
                        <input class="form-check-input" type="checkbox" id="problemas_respiratorios">
                        <label class="form-check-label">Problemas Respiratórios</label>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-3 form-check">
                        <input class="form-check-input" type="checkbox" id="doencas_infecciosas">
                        <label class="form-check-label">Doenças Infecciosas</label>
                    </div>

                    <div class="col-md-3 form-check">
                        <input class="form-check-input" type="checkbox" id="doencas_osseas">
                        <label class="form-check-label">Doenças Ósseas</label>
                    </div>

                    <div class="col-md-3 form-check">
                        <input class="form-check-input" type="checkbox" id="cancer">
                        <label class="form-check-label">Câncer</label>
                    </div>

                    <div class="col-md-3 form-check">
                        <input class="form-check-input" type="checkbox" id="convulsoes">
                        <label class="form-check-label">Convulsões</label>
                    </div>
                </div>

                <hr>

                <!-- =====================
                     MEDICAMENTOS / CIRURGIAS
                ====================== -->
                <h6 class="fw-bold mb-3">Medicamentos e Cirurgias</h6>

                <div class="row">
                    <div class="col-md-4 form-check">
                        <input class="form-check-input" type="checkbox" id="em_tratamento_medico">
                        <label class="form-check-label">Em tratamento médico</label>
                    </div>

                    <div class="col-md-4 form-check">
                        <input class="form-check-input" type="checkbox" id="hospitalizado_ou_operado">
                        <label class="form-check-label">Hospitalizado / Operado</label>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Medicamentos em uso</label>
                        <input type="text" class="form-control" id="medicamentos_em_uso">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Detalhes das Cirurgias</label>
                        <input type="text" class="form-control" id="detalhes_cirurgias">
                    </div>
                </div>

                <hr>

                <!-- =====================
                     HÁBITOS
                ====================== -->
                <h6 class="fw-bold mb-3">Hábitos</h6>

                <div class="row">
                    <div class="col-md-3 form-check">
                        <input class="form-check-input" type="checkbox" id="tabagista">
                        <label class="form-check-label">Tabagista</label>
                    </div>

                    <div class="col-md-3 form-check">
                        <input class="form-check-input" type="checkbox" id="consumo_alcool">
                        <label class="form-check-label">Consumo de Álcool</label>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Tipo de Tabaco</label>
                        <input type="text" class="form-control" id="tipo_tabaco">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Frequência de Álcool</label>
                        <input type="text" class="form-control" id="frequencia_alcool">
                    </div>
                </div>

                <hr>

                <!-- =====================
                     HIGIENE BUCAL
                ====================== -->
                <h6 class="fw-bold mb-3">Higiene Bucal</h6>

                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">Escovações por dia</label>
                        <input type="number" class="form-control" id="escovacoes_por_dia" min="0">
                    </div>

                    <div class="col-md-4 form-check mt-4">
                        <input class="form-check-input" type="checkbox" id="usa_fio_dental">
                        <label class="form-check-label">Usa fio dental</label>
                    </div>

                    <div class="col-md-4 form-check mt-4">
                        <input class="form-check-input" type="checkbox" id="bruxismo">
                        <label class="form-check-label">Bruxismo</label>
                    </div>
                </div>

                <hr>

                <!-- =====================
                     HISTÓRICO FAMILIAR / OBS
                ====================== -->
                <h6 class="fw-bold mb-3">Histórico Familiar</h6>

                <div class="mb-3">
                    <label class="form-label">Doenças Hereditárias</label>
                    <input type="text" class="form-control" id="doencas_hereditarias">
                </div>

                <div class="mb-4">
                    <label class="form-label">Observações</label>
                    <textarea class="form-control" id="observacoes" rows="4"></textarea>
                </div>

                <!-- =====================
                     BOTÕES
                ====================== -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>
                        Salvar Alterações
                    </button>

                    <a href="/teamOdonto/public/index.php?page=anamnese-list"
                       class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>
</main>

<script src="/teamOdonto/public/js/anamnese/anamnese-edit.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>