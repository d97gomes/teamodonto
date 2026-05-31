<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

$title = 'Cadastro de Paciente';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
    <nav class="navbar navbar-custom sticky-top">
        <h5 class="mb-0 fw-bold">Cadastro de Paciente</h5>
    </nav>

    <div class="p-4 p-lg-5">
        <div class="card p-4 border-0 shadow-sm">

            <form id="formPaciente">

                <!-- DADOS PESSOAIS -->
                <h6 class="fw-bold mb-3">Dados Pessoais</h6>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-semibold">Nome completo</label>
                        <input class="form-control" name="nome" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">CPF</label>
                        <input class="form-control" name="cpf" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Sexo</label>
                        <select class="form-select" name="sexo" required>
                            <option value="">Selecione</option>
                            <option value="MASCULINO">Masculino</option>
                            <option value="FEMININO">Feminino</option>
                            <option value="OUTROS">Outros</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Telefone</label>
                        <input class="form-control" name="telefone">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input class="form-control" name="email">
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-semibold">Data de Nascimento</label>
                        <input type="date" class="form-control" name="data_nascimento">
                    </div>
                </div>

                <!-- ENDEREÇO -->
                <h6 class="fw-bold mt-4 mb-3">Endereço</h6>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">CEP</label>
                        <input class="form-control" name="cep">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Rua</label>
                        <input class="form-control" name="logradouro" required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Número</label>
                        <input class="form-control" name="numero">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Complemento</label>
                        <input class="form-control" name="complemento">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Bairro</label>
                        <input class="form-control" name="bairro" required>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-semibold">Cidade</label>
                        <input class="form-control" name="cidade" required>
                    </div>

                    <div class="col-md-3 mb-4">
                        <label class="form-label fw-semibold">Estado</label>
                        <input class="form-control" name="estado" required>
                    </div>
                </div>

                <!-- AÇÕES -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="/teamOdonto/public/index.php?page=paciente-list"
                       class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary fw-semibold">
                        Salvar Paciente
                    </button>
                </div>

            </form>

        </div>
    </div>
</main>

<script src="/teamOdonto/public/js/paciente/paciente-create.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>