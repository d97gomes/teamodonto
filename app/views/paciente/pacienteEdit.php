<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../models/PacienteModel.php';


if (!isset($_GET['id'])) {
    header('Location: pacienteList.php');
    exit;
}

$model = new PacienteModel();
$paciente = $model->buscarPorId((int)$_GET['id']);

if (!$paciente) {
    header('Location: pacienteList.php');
    exit;
}

$title = 'Editar Paciente';
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/navbar.php';
require_once __DIR__ . '/../includes/sidebar.php';
?>

<div class="container py-4">
    <h3 class="mb-4">Editar Paciente</h3>

    <form id="formPaciente">

        <h5>Dados Pessoais</h5>
        <input class="form-control mb-2"
               name="nome"
               value="<?= htmlspecialchars($paciente['nome']) ?>">

        <input class="form-control mb-2"
               name="cpf"
               value="<?= htmlspecialchars($paciente['cpf']) ?>">

        <input class="form-control mb-2"
               name="telefone"
               value="<?= htmlspecialchars($paciente['telefone']) ?>">

        <input class="form-control mb-2"
               name="email"
               value="<?= htmlspecialchars($paciente['email']) ?>">

        <input type="date"
               class="form-control mb-3"
               name="data_nascimento"
               value="<?= $paciente['data_nascimento'] ?>">

        <h5>Endereço</h5>

        <input class="form-control mb-2"
               name="cep"
               value="<?= htmlspecialchars($paciente['cep']) ?>">

        <input class="form-control mb-2"
               name="logradouro"
               value="<?= htmlspecialchars($paciente['logradouro']) ?>">

        <input class="form-control mb-2"
               name="numero"
               value="<?= htmlspecialchars($paciente['numero']) ?>">

        <input class="form-control mb-2"
               name="complemento"
               value="<?= htmlspecialchars($paciente['complemento']) ?>">

        <input class="form-control mb-2"
               name="bairro"
               value="<?= htmlspecialchars($paciente['bairro']) ?>">

        <input class="form-control mb-2"
               name="cidade"
               value="<?= htmlspecialchars($paciente['cidade']) ?>">

        <input class="form-control mb-3"
               name="estado"
               value="<?= htmlspecialchars($paciente['estado']) ?>">

        <button class="btn btn-primary">Salvar Alterações</button>
        <a href="pacienteList.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<script src="/teamOdonto/public/js/paciente/paciente-edit.js"></script>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
