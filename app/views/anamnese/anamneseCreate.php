<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$title = 'Nova Anamnese';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <div class="container-fluid py-4">

        <!-- HEADER DA PÁGINA -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 fw-bold">Nova Anamnese</h3>

            <a href="/teamOdonto/public/index.php?page=anamnese-list"
               class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>
                Voltar
            </a>
        </div>

        <!-- CARD PRINCIPAL -->
        <div class="card p-4">

            <form id="formAnamnese">

                <!-- =====================
                     PACIENTE / DENTISTA
                ====================== -->
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-person-lines-fill fs-5 text-primary me-2"></i>
                    <h6 class="fw-bold mb-0">Paciente e Dentista</h6>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Paciente *</label>
                        <input type="text" class="form-control" id="buscarPaciente"
                               placeholder="Digite nome ou CPF">
                        <input type="hidden" id="paciente_id">
                        <ul class="list-group mt-1" id="listaPacientes"></ul>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Dentista *</label>
                        <input type="text" class="form-control" id="buscarDentista"
                               placeholder="Digite nome ou CRO">
                        <input type="hidden" id="dentista_id">
                        <ul class="list-group mt-1" id="listaDentistas"></ul>
                    </div>
                </div>

                <hr>

                <!-- =====================
                     HISTÓRICO MÉDICO
                ====================== -->
                <h6 class="fw-bold mb-3">Histórico Médico</h6>

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

                <div class="row mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Alergias</label>
                        <input type="text" class="form-control" id="alergias">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Outras Doenças</label>
                        <input type="text" class="form-control" id="outras_doencas">
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
                        Salvar Anamnese
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

<script src="/teamOdonto/public/js/anamnese/anamnese-create.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>