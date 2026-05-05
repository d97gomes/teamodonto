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

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0">Editar Anamnese</h3>

        <a href="/teamOdonto/public/index.php?page=anamnese-list"
           class="btn btn-outline-secondary">
            Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-header fw-bold">Dados Clínicos</div>

        <div class="card-body">
            <form id="formAnamneseEdit" data-id="<?= (int)$id ?>">

                <!-- HISTÓRICO MÉDICO -->
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

                <hr>

                <!-- TEXTOS -->
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Alergias</label>
                        <input type="text" class="form-control" id="alergias">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Medicamentos em uso</label>
                        <input type="text" class="form-control" id="medicamentos_em_uso">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Observações</label>
                    <textarea class="form-control" id="observacoes" rows="4"></textarea>
                </div>

                <hr>

                <!-- BOTÕES -->
                <button type="submit" class="btn btn-primary">
                    Salvar Alterações
                </button>

                <a href="/teamOdonto/public/index.php?page=anamnese-list"
                   class="btn btn-secondary">
                    Cancelar
                </a>

            </form>
        </div>
    </div>
</div>

<script src="/teamOdonto/public/js/anamnese/anamnese-edit.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>