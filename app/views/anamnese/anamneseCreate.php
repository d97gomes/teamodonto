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

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Nova Anamnese</h3>

        <a href="/teamOdonto/public/index.php?page=anamnese-list"
           class="btn btn-outline-secondary">
            Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-header fw-bold">Dados da Anamnese</div>

        <div class="card-body">
            <form id="formAnamnese">

                <!-- =====================
                     PACIENTE / DENTISTA
                ====================== -->
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
                <h6 class="fw-bold">Histórico Médico</h6>

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
                <h6 class="fw-bold">Medicamentos e Cirurgias</h6>

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

                <div class="row mt-2">
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
                <h6 class="fw-bold">Hábitos</h6>

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

                <div class="row mt-2">
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
                <h6 class="fw-bold">Higiene Bucal</h6>

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
                <h6 class="fw-bold">Histórico Familiar</h6>

                <div class="mb-3">
                    <label class="form-label">Doenças Hereditárias</label>
                    <input type="text" class="form-control" id="doencas_hereditarias">
                </div>

                <div class="mb-3">
                    <label class="form-label">Observações</label>
                    <textarea class="form-control" id="observacoes" rows="4"></textarea>
                </div>

                <!-- =====================
                     BOTÕES
                ====================== -->
                <button type="submit" class="btn btn-primary">
                    Salvar Anamnese
                </button>

                <a href="/teamOdonto/public/index.php?page=anamnese-list"
                   class="btn btn-secondary">
                    Cancelar
                </a>

            </form>
        </div>
    </div>
</div>

<script src="/teamOdonto/public/js/anamnese/anamnese-create.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
