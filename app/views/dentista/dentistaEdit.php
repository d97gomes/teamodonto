<?php
if (!defined('APP_ROUTER')) {
    header('Location: /teamOdonto/public/index.php?page=login');
    exit;
}

require_once __DIR__ . '/../../config/database.php';
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
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<div class="container py-4">
    <h3 class="mb-4">Editar Dentista</h3>

    <form id="formDentista">

        <h5>Dados Pessoais</h5>

        <input class="form-control mb-2"
               name="nome"
               value="<?= htmlspecialchars($dentista['nome']) ?>"
               required>

        <input class="form-control mb-2"
               name="cpf"
               value="<?= htmlspecialchars($dentista['cpf']) ?>"
               required>

        <select class="form-select mb-2" name="sexo" required>
            <option value="">Selecione o sexo</option>

            <option value="MASCULINO"
                <?= (isset($dentista['sexo']) && $dentista['sexo'] === 'MASCULINO') ? 'selected' : '' ?>>
                Masculino
            </option>

            <option value="FEMININO"
                <?= (isset($dentista['sexo']) && $dentista['sexo'] === 'FEMININO') ? 'selected' : '' ?>>
                Feminino
            </option>

            <option value="OUTROS"
                <?= (isset($dentista['sexo']) && $dentista['sexo'] === 'OUTROS') ? 'selected' : '' ?>>
                Outros
            </option>
        </select>

        <input class="form-control mb-2"
               name="telefone"
               value="<?= htmlspecialchars($dentista['telefone']) ?>">

        <input class="form-control mb-3"
               name="email"
               value="<?= htmlspecialchars($dentista['email']) ?>">

        <h5>Dados Profissionais</h5>

        <input class="form-control mb-2"
               name="cro"
               value="<?= htmlspecialchars($dentista['cro']) ?>"
               required>

        <input class="form-control mb-3"
               name="especialidade"
               value="<?= htmlspecialchars($dentista['especialidade']) ?>"
               required>

        <h5>Endereço</h5>

        <input class="form-control mb-2"
               name="cep"
               value="<?= htmlspecialchars($dentista['cep']) ?>">

        <input class="form-control mb-2"
               name="logradouro"
               value="<?= htmlspecialchars($dentista['logradouro']) ?>"
               required>

        <input class="form-control mb-2"
               name="numero"
               value="<?= htmlspecialchars($dentista['numero']) ?>">

        <input class="form-control mb-2"
               name="complemento"
               value="<?= htmlspecialchars($dentista['complemento']) ?>">

        <input class="form-control mb-2"
               name="bairro"
               value="<?= htmlspecialchars($dentista['bairro']) ?>"
               required>

        <input class="form-control mb-2"
               name="cidade"
               value="<?= htmlspecialchars($dentista['cidade']) ?>"
               required>

        <input class="form-control mb-3"
               name="estado"
               value="<?= htmlspecialchars($dentista['estado']) ?>"
               required>

        <button class="btn btn-primary">Salvar Alterações</button>

        <a href="/teamOdonto/public/index.php?page=dentista-list"
           class="btn btn-secondary">
            Cancelar
        </a>
    </form>
</div>

<script src="/teamOdonto/public/js/dentista/dentista-edit.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>