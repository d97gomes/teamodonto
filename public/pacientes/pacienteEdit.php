<?php
include '../layout/sidebar.php';

require_once '../../app/config/database.php';
require_once '../../app/controllers/pacienteController.php';

$db = Database::conectar();
$controller = new PacienteController($db);

// Recebe o ID do paciente
$id = $_GET['id'] ?? 0;

// Busca paciente + endereço
$paciente = $controller->buscarPacientePorId((int)$id);

if (!$paciente) {
    echo "<p>Paciente não encontrado.</p>";
    include '../layout/footer.php';
    exit;
}
?>

<h3>Editar Paciente</h3>

<!-- Mensagens de feedback -->
<div id="mensagem"></div>

<form id="formPacienteEdit">

    <!-- IDs necessários para o UPDATE -->
    <input type="hidden" name="id" value="<?= $paciente['id']; ?>">
    <input type="hidden" name="endereco_id" value="<?= $paciente['endereco_id']; ?>">

    <h5 class="mt-4">Dados do Paciente</h5>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Nome</label>
            <input
                type="text"
                name="nome"
                class="form-control"
                value="<?= $paciente['nome']; ?>"
                required
            >
        </div>

        <div class="col-md-3">
            <label class="form-label">CPF</label>
            <input
                type="text"
                name="cpf"
                class="form-control"
                value="<?= $paciente['cpf']; ?>"
                required
            >
        </div>

        <div class="col-md-3">
            <label class="form-label">Telefone</label>
            <input
                type="text"
                name="telefone"
                class="form-control"
                value="<?= $paciente['telefone']; ?>"
            >
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">E-mail</label>
            <input
                type="email"
                name="email"
                class="form-control"
                value="<?= $paciente['email']; ?>"
            >
        </div>

        <div class="col-md-3">
            <label class="form-label">Sexo</label>
            <select name="sexo" class="form-select">
                <option value="">Selecione</option>
                <option value="M" <?= $paciente['sexo'] === 'M' ? 'selected' : ''; ?>>
                    Masculino
                </option>
                <option value="F" <?= $paciente['sexo'] === 'F' ? 'selected' : ''; ?>>
                    Feminino
                </option>
            </select>
        </div>

        <div class="col-md-3">
            <label class="form-label">Data de Nascimento</label>
            <input
                type="date"
                name="dataNascimento"
                class="form-control"
                value="<?= $paciente['dataNascimento']; ?>"
            >
        </div>
    </div>

    <h5 class="mt-4">Endereço</h5>

    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Rua</label>
            <input
                type="text"
                name="rua"
                class="form-control"
                value="<?= $paciente['rua']; ?>"
                required
            >
        </div>

        <div class="col-md-2">
            <label class="form-label">Número</label>
            <input
                type="text"
                name="numero"
                class="form-control"
                value="<?= $paciente['numero']; ?>"
            >
        </div>

        <div class="col-md-4">
            <label class="form-label">Bairro</label>
            <input
                type="text"
                name="bairro"
                class="form-control"
                value="<?= $paciente['bairro']; ?>"
                required
            >
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4">
            <label class="form-label">Complemento</label>
            <input
                type="text"
                name="complemento"
                class="form-control"
                value="<?= $paciente['complemento']; ?>"
            >
        </div>

        <div class="col-md-4">
            <label class="form-label">Cidade</label>
            <input
                type="text"
                name="cidade"
                class="form-control"
                value="<?= $paciente['cidade']; ?>"
                required
            >
        </div>

        <div class="col-md-2">
            <label class="form-label">Estado</label>
            <input
                type="text"
                name="estado"
                class="form-control"
                maxlength="2"
                value="<?= $paciente['estado']; ?>"
                required
            >
        </div>

        <div class="col-md-2">
            <label class="form-label">CEP</label>
            <input
                type="text"
                name="cep"
                class="form-control"
                value="<?= $paciente['cep']; ?>"
            >
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="pacienteList.php" class="btn btn-secondary">Voltar</a>
    </div>

</form>

<!-- Axios + JS do módulo -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../js/paciente.js"></script>

<?php include '../layout/footer.php'; ?>