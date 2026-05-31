<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

require_once __DIR__ . '/../../models/DentistaModel.php';

if (!isset($_GET['id'])) {
    header('Location: /teamOdonto/public/index.php?page=dentista-list');
    exit;
}

$model = new DentistaModel();
$dentista = $model->buscarPorId((int) $_GET['id']);

if (!$dentista) {
    header('Location: /teamOdonto/public/index.php?page=dentista-list');
    exit;
}

$title = 'Editar Dentista';

require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<main class="main-content">
       <div class="container-fluid py-4">
    <nav class="navbar navbar-custom sticky-top">
        <h5 class="mb-0 fw-bold">Editar Dentista</h5>
    </nav>

    <div class="p-4 p-lg-5">
        <div class="card p-4 border-0 shadow-sm">

            <form id="formDentista">

                <!-- DADOS PESSOAIS -->
                <h6 class="fw-bold mb-3">Dados Pessoais</h6>

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-semibold">Nome completo</label>
                        <input class="form-control"
                               name="nome"
                               value="<?= htmlspecialchars($dentista['nome']) ?>"
                               required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">CPF</label>
                        <input class="form-control"
                               name="cpf"
                               value="<?= htmlspecialchars($dentista['cpf']) ?>"
                               required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Sexo</label>
                        <select class="form-select" name="sexo" required>
                            <option value="">Selecione</option>
                            <option value="MASCULINO" <?= $dentista['sexo'] === 'MASCULINO' ? 'selected' : '' ?>>Masculino</option>
                            <option value="FEMININO" <?= $dentista['sexo'] === 'FEMININO' ? 'selected' : '' ?>>Feminino</option>
                            <option value="OUTROS" <?= $dentista['sexo'] === 'OUTROS' ? 'selected' : '' ?>>Outros</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Telefone</label>
                        <input class="form-control"
                               name="telefone"
                               value="<?= htmlspecialchars($dentista['telefone']) ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input class="form-control"
                               name="email"
                               value="<?= htmlspecialchars($dentista['email']) ?>">
                    </div>
                </div>

                <!-- DADOS PROFISSIONAIS -->
                <h6 class="fw-bold mt-4 mb-3">Dados Profissionais</h6>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">CRO</label>
                        <input class="form-control"
                               name="cro"
                               value="<?= htmlspecialchars($dentista['cro']) ?>"
                               required>
                    </div>

                    <div class="col-md-8 mb-3">
                        <label class="form-label fw-semibold">Especialidade</label>
                        <input class="form-control"
                               name="especialidade"
                               value="<?= htmlspecialchars($dentista['especialidade']) ?>"
                               required>
                    </div>
                </div>

                <!-- ENDEREÇO -->
                <h6 class="fw-bold mt-4 mb-3">Endereço</h6>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">CEP</label>
                        <input class="form-control"
                               name="cep"
                               value="<?= htmlspecialchars($dentista['cep']) ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Rua</label>
                        <input class="form-control"
                               name="logradouro"
                               value="<?= htmlspecialchars($dentista['logradouro']) ?>"
                               required>
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-semibold">Número</label>
                        <input class="form-control"
                               name="numero"
                               value="<?= htmlspecialchars($dentista['numero']) ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Complemento</label>
                        <input class="form-control"
                               name="complemento"
                               value="<?= htmlspecialchars($dentista['complemento']) ?>">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-semibold">Bairro</label>
                        <input class="form-control"
                               name="bairro"
                               value="<?= htmlspecialchars($dentista['bairro']) ?>"
                               required>
                    </div>

                    <div class="col-md-4 mb-4">
                        <label class="form-label fw-semibold">Cidade</label>
                        <input class="form-control"
                               name="cidade"
                               value="<?= htmlspecialchars($dentista['cidade']) ?>"
                               required>
                    </div>

                    <div class="col-md-3 mb-4">
                        <label class="form-label fw-semibold">Estado</label>
                        <input class="form-control"
                               name="estado"
                               value="<?= htmlspecialchars($dentista['estado']) ?>"
                               required>
                    </div>
                </div>

                <!-- AÇÕES -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="/teamOdonto/public/index.php?page=dentista-list"
                       class="btn btn-secondary">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary fw-semibold">
                        Salvar Alterações
                    </button>
                </div>

            </form>

        </div>
    </div>
    <div>
</main>

<script src="/teamOdonto/public/js/dentista/dentista-edit.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>